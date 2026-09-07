# Concerns reference

All in `Morrislaptop\LaravelBootMaker\Concerns\`. Add the fewest that make the test pass.

## Error to concern

| The failure you see | Add |
| --- | --- |
| `Target class [config] does not exist`, or `config()` returns null | `Config` |
| `Target class [translator]`, or a translation key comes back untranslated | `Translation` |
| `Target class [db]`, any Eloquent relation error, `Unknown format "uuid"` from a factory | `Database` |
| `Target class [validator]` | `Validation` |
| `Target class [view]` | `Views` |
| `Target class [cache]` | `Cache` |
| `Target class [log]` | `Logging` |
| `Target class [files]` | `Filesystem` |
| `Target class [events]` | `Events` |
| `Target class [queue]` | `Queues` |
| `Target class [encrypter]` | `Encrypting` |
| `Target class [hash]` | `Hashing` |
| `Target class [mailer]` | `Mail` |
| `A facade root has not been set` | `Facades` |
| `$this->get()` returns 404, or `Target class [router]` | `Routes` |
| `Target class [auth]`, `actingAs()` fails, `$request->user()` is null | `Auth` |
| `$this->faker` is undefined | `WithFaker` |
| An `env()` value reads as null | `Environment` |
| `$this->artisan()` | `Console` |
| `The command "x" does not exist` | name it in `consoleCommands()` |
| `no such table` | `RefreshDatabase` or `DatabaseMigrations` |
| `Target [X] is not instantiable` while building a listener | override `eventServiceProvider()` |
| A route or command needs a package's provider (Inertia macros, localisation, auditing) | list it in `additionalProviders()` |

## What each registers

| Concern | Registers | Pulls in |
| --- | --- | --- |
| `Environment` | `LoadEnvironmentVariables` bootstrapper | — |
| `Config` | `LoadConfiguration` bootstrapper | `Environment` |
| `Facades` | `RegisterFacades` bootstrapper | — |
| `SetRequestForConsole` | `SetRequestForConsole` bootstrapper | — |
| `Filesystem` | `FilesystemServiceProvider` | `Config` |
| `Translation` | `TranslationServiceProvider` | `Filesystem` |
| `Validation` | `ValidationServiceProvider`, `FoundationServiceProvider` for the `$request->validate()` macro, and a booted `FormRequestServiceProvider` | `Translation` |
| `Views` | `ViewServiceProvider` | `Filesystem` |
| `Database` | `DatabaseServiceProvider` | `Config` |
| `Cache` | `CacheServiceProvider` | `Config` |
| `Logging` | `LogServiceProvider` | `Config` |
| `Hashing` | `HashServiceProvider` | `Config` |
| `Encrypting` | `EncryptionServiceProvider` | `Config` |
| `Bus` | `BusServiceProvider` | — |
| `Queues` | `QueueServiceProvider` | `Bus` |
| `Mail` | `MailServiceProvider` | `Config`, `Views` |
| `Notifications` | `NotificationServiceProvider` | — |
| `Events` | `FilesystemServiceProvider`, `CacheServiceProvider`, and the app's `App\Providers\EventServiceProvider` if it has one, else the framework's | — |
| `Routes` | `RoutingServiceProvider`, `additionalProviders()`, the app's route provider, and a `PartialHttpKernel` | `Config`, `Events`, `Facades`, `SetRequestForConsole`, `Views` |
| `Auth` | `CookieServiceProvider`, `SessionServiceProvider`, `AuthServiceProvider` | `Config`, `Events`, `Hashing`, `SetRequestForConsole` |
| `Console` | marks the app bootstrapped without bootstrapping, plus `ConsoleSupportServiceProvider`, `additionalProviders()` and `consoleCommands()` | `Config`, `Events`, `Facades` |
| `RefreshDatabase` | Laravel's `RefreshDatabase` | `Console`, `Database` |
| `DatabaseMigrations` | Laravel's `DatabaseMigrations` | `Console`, `Database` |
| `WithFaker` | Laravel's `WithFaker` | `Config` |
| `DatabaseTransactions` | Laravel's `DatabaseTransactions` | — |

Because concerns pull in others, name only the one you need: `Validation` already gives
you `Translation` and `Filesystem`.

## Hooks

Both live on `PartialTestCase`, not on a concern trait, because a trait method wins over an
inherited one and an override on your own `Tests\PartialTestCase` would silently lose.

### `eventServiceProvider()`

`Events` prefers the application's own `App\Providers\EventServiceProvider`, since that maps
its listeners. Laravel 11 and later do not ship one; the fallback is the framework's, which
binds the dispatcher and nothing else.

An application's provider often maps subscribers whose dependencies only bind under a full
boot: `Target [X] is not instantiable while building [SomeSubscriber]`. Force the
framework's then:

```php
protected function eventServiceProvider(): ServiceProvider
{
    return new \Illuminate\Events\EventServiceProvider($this->app);
}
```

### `additionalProviders()`

Providers no concern covers, which a route file, controller or command reaches for.

```php
protected function additionalProviders(): array
{
    return [
        \Inertia\ServiceProvider::class,          // its TestResponse macros
        \App\Providers\MacrosServiceProvider::class,
    ];
}
```

Only `Routes` and `Console` register these, after every other concern has run. A provider
has prerequisites of its own — one adding a request macro needs `request` bound — so a test
that runs no application code should not pay for one. Expect the concern list of a `Routes`
or `Console` test to grow to satisfy the providers rather than the test itself.

A package whose config its provider merges needs listing even when the application has
published that config: the published file is usually only part of it.

## Requests without the framework

`Routes` swaps the application's HTTP kernel for `PartialHttpKernel`, which skips the
bootstrappers and the middleware stack. `$this->get()` and friends work as usual, exception
handler included, so a missing route is still a 404 and a `ValidationException` a 422.

It runs last whatever order the traits are declared in, because route files run application
code that can touch any other concern. That is also why a route test often needs concerns
it does not appear to use: a route file calling a localisation package resolves `translator`
while registering, so it needs `Translation` even though it translates nothing. Read the
failure as "the route file needs this".

The container is never booted, only the route provider and `additionalProviders()`. Booting
it would replay every `bootstrap/app.php` callback, dragging in `withBroadcasting()` and
friends.

**Middleware does not run.** It is defined by the real kernel and wants sessions, cookies
and CSRF, so `Routes` tests the route, its controller and what they call — not auth
middleware, throttling or CSRF. `WithoutMiddleware` is redundant alongside it.

`Auth` registers the guard directly. An in-memory user is enough; a lookup by id needs
`Database` too.

## Commands and migrations without the framework

`Console` marks the application as bootstrapped without running a single bootstrapper, so
the console kernel skips its own bootstrap but stays in place. It also registers the
framework's commands, so `migrate` and `make:*` are there.

**Name the commands you run.** Laravel 11 registers an application's commands, and its
`routes/console.php`, from a callback only a full boot fires:

```php
protected function consoleCommands(): array
{
    return [\App\Console\Commands\PruneProductTags::class];
}
```

Naming them is the point: pointing the kernel at a command directory would build every
command in it, and every binding those need. A Laravel 10 kernel with its own `commands()`
method still loads from there.

**The schedule cannot be read.** It comes from that same callback, so a partial boot would
report it empty and quietly pass a test asserting nothing is scheduled. Resolving
`Schedule` throws `FullBootRequired` instead.

`RefreshDatabase` and `DatabaseMigrations` were only ever blocked because they run
`$this->artisan('migrate')`. Both now migrate partially booted. They are **not** a drop-in
for an application overriding `refreshTestDatabase()` to cache a migration checksum or
seed: they run `migrate:fresh` and skip it. Compose your own trait instead.

The gain scales with how many providers your application boots: a real application measured
4.6x and 7.5x on command tests, a bare fixture app only 1.6x. Migration-heavy tests gain
least, around 1.4x, since running the migrations dominates.

## What still needs a full boot

Only the schedule guard throws `FullBootRequired` now. What is left is:

- a test asserting on **middleware** behaviour: auth redirects, throttling, CSRF
- a test reading the **schedule**
- code reaching a binding only an application or package provider registers, when that
  provider cannot be built partially (a model calling into Nova, say). Try
  `additionalProviders()` first; if the provider itself needs a full boot, stop there.
