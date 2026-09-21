# Concerns reference

All in `Morrislaptop\LaravelBootMaker\Concerns\`. Add the fewest that make the test pass.

## Error to concern

| The failure you see | Add |
| --- | --- |
| `Target class [config] does not exist`, or `config()` returns null | `Config` |
| `Target class [translator]`, or a translation key comes back untranslated | `Translation` |
| `Target class [db]`, any Eloquent relation error, `Unknown format "uuid"` from a factory | `Database` |
| `Target class [request]` | `SetRequestForConsole` |
| `Class "Context" not found` | `Facades` |
| `Target class [session.store]` | `Auth`, which registers the session — not a session concern |
| `Session store not set on request` | `Auth` |
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
| `Target class [db]` from a route with a model parameter | `Database` |
| `Target class [auth]`, `actingAs()` fails, `$request->user()` is null | `Auth` |
| `$this->faker` is undefined | `WithFaker` |
| An `env()` value reads as null | `Environment` |
| `$this->artisan()` | `Console` |
| `The command "x" does not exist` | name it in `consoleCommands()` |
| `no such table` | `RefreshDatabase` or `DatabaseMigrations` |
| `Target [X] is not instantiable` while building a listener | override `eventServiceProvider()` |
| A route or command needs a package's provider (Inertia macros, localisation, auditing) | list it in `additionalProviders()` |
| `Target [SomeContract] is not instantiable` naming a package's class | list the package's provider in `additionalProviders()`. Add `AdditionalProviders` if the test makes no request and runs no command |
| A package's query builder or connection features are missing, though its provider is listed | move the provider to `databaseProviders()` |
| `Fatal error: Cannot use ... as Auth because the name is already in use` | alias the concern, not the facade |
| `Nothing is bound for [Illuminate\Support\Facades\Auth]`, only when other tests run first | the concern that binds `auth` |

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
| `Database` | `DatabaseServiceProvider` and `databaseProviders()`. Does not roll back | `Config` |
| `Cache` | `CacheServiceProvider` | `Config` |
| `Logging` | `LogServiceProvider` | `Config` |
| `Hashing` | `HashServiceProvider` | `Config` |
| `Encrypting` | `EncryptionServiceProvider` | `Config` |
| `Bus` | `BusServiceProvider` | — |
| `Queues` | `QueueServiceProvider` | `Bus` |
| `Mail` | `MailServiceProvider` | `Config`, `Views` |
| `Notifications` | `NotificationServiceProvider` | — |
| `Events` | `FilesystemServiceProvider`, `CacheServiceProvider`, and the app's `App\Providers\EventServiceProvider` if it has one, else the framework's | — |
| `AdditionalProviders` | `additionalProviders()` | `Config`, `Facades`, `SetRequestForConsole` |
| `Routes` | `RoutingServiceProvider`, `additionalProviders()`, the app's route provider, and a `PartialHttpKernel`. Runs route model binding | `Config`, `Events`, `Facades`, `SetRequestForConsole`, `Views` |
| `Auth` | `CookieServiceProvider`, `SessionServiceProvider`, `AuthServiceProvider` | `Config`, `Events`, `Hashing`, `SetRequestForConsole` |
| `Console` | marks the app bootstrapped without bootstrapping, plus `ConsoleSupportServiceProvider`, `additionalProviders()` and `consoleCommands()` | `Config`, `Events`, `Facades` |
| `RefreshDatabase` | Laravel's `RefreshDatabase` | `Console`, `Database` |
| `DatabaseMigrations` | Laravel's `DatabaseMigrations` | `Console`, `Database` |
| `WithFaker` | Laravel's `WithFaker` | `Config` |
| `DatabaseTransactions` | Laravel's `DatabaseTransactions` | `Database` |

Concerns pull in others, so name only the one you need: `Validation` already gives you
`Translation` and `Filesystem`.

**`Database` alone does not roll back.** A test that writes keeps its rows, and the next
test sees them. Use `DatabaseTransactions` or `RefreshDatabase` for any test that writes.

## Trait names collide with facade names

`Auth`, `Cache`, `Mail`, `Queues`, `Bus`, `Events`, `Notifications` and `Validation` are
both a concern and a facade. Importing both is a PHP fatal error. Alias the concern:

```php
use Illuminate\Support\Facades\Auth;
use Morrislaptop\LaravelBootMaker\Concerns\Auth as AuthConcern;
```

## Hooks

Override these on your own `Tests\PartialTestCase`.

### `eventServiceProvider()`

`Events` uses `App\Providers\EventServiceProvider` if it exists, else the framework's.
If the app's provider fails with `Target [X] is not instantiable while building
[SomeSubscriber]`, use the framework's:

```php
protected function eventServiceProvider(): ServiceProvider
{
    return new \Illuminate\Events\EventServiceProvider($this->app);
}
```

### `additionalProviders()`

Providers that no concern covers:

```php
protected function additionalProviders(): array
{
    return [
        \Inertia\ServiceProvider::class,          // its TestResponse macros
        \App\Providers\MacrosServiceProvider::class,
    ];
}
```

- Only `Routes`, `Console` and `AdditionalProviders` register them, after all other
  concerns.
- A provider can need more concerns than the test itself, for example `request` for a
  request macro.
- No request and no command? Use `AdditionalProviders`, not `Routes`. Then re-run: you
  lose the concerns `Routes` pulled in.
- List a package's provider even when its config is published. The provider merges the
  rest of the config.

### `databaseProviders()`

Providers that change the database layer, for example one that rebinds `db.factory`:

```php
protected function databaseProviders(): array
{
    return [\Vendor\Package\DatabaseServiceProvider::class];
}
```

- `Database` registers them after the framework's database provider registers and before
  it boots. Boot builds the manager, which keeps the `db.factory` it was given.
- In `additionalProviders()` they come too late: the manager already has the old factory.

## Requests

`Routes` replaces the HTTP kernel with `PartialHttpKernel`. It has no bootstrappers and no
middleware. The exception handler still runs: a missing route is a 404, a
`ValidationException` is a 422.

- `Routes` runs last, because route files run application code. So a route test can need
  concerns it does not seem to use. Read the error as "the route file needs this".
- **Middleware does not run.** Test middleware on the full `TestCase`.
  `WithoutMiddleware` is not needed with `Routes`.
- Route model binding still runs. A missing model is a 404.
- `Auth` is enough for an in-memory user and `$request->session()`. To find a user by id,
  add `Database`.

## Commands and migrations

`Console` lets `$this->artisan()` run. The framework's commands (`migrate`, `make:*`) are
available.

On Laravel 11 and later, list the commands the test runs. A Laravel 10 kernel with its own
`commands()` method still works.

```php
protected function consoleCommands(): array
{
    return [\App\Console\Commands\PruneProductTags::class];
}
```

- **The schedule is not available.** Resolving `Schedule` throws `FullBootRequired`.
- `RefreshDatabase` and `DatabaseMigrations` run `migrate:fresh`. They ignore an override
  of `refreshTestDatabase()`. If you need one, write your own trait.
- Tests that run many migrations gain the least.

## What still needs a full boot

- a test of **middleware**: auth redirects, throttling, CSRF
- a test that reads data shared by middleware, for example Inertia's shared props from
  `HandleInertiaRequests`. Under `Routes` it is absent
- a test of the **schedule**
- code that needs a provider which cannot boot partially, for example Nova. Try
  `additionalProviders()` first.
