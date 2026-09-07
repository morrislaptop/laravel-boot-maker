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
| `$this->faker` is undefined | `WithFaker` |
| An `env()` value reads as null | `Environment` |

## What each registers

| Concern | Registers | Pulls in |
| --- | --- | --- |
| `Environment` | `LoadEnvironmentVariables` bootstrapper | — |
| `Config` | `LoadConfiguration` bootstrapper | — |
| `Facades` | `RegisterFacades` bootstrapper | — |
| `SetRequestForConsole` | `SetRequestForConsole` bootstrapper | — |
| `Filesystem` | `FilesystemServiceProvider` | `Config` |
| `Translation` | `TranslationServiceProvider` | `Filesystem` |
| `Validation` | `ValidationServiceProvider` | `Translation` |
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
| `WithFaker` | Laravel's `WithFaker` | `Config` |
| `DatabaseTransactions` | Laravel's `DatabaseTransactions` | — |

Because concerns pull in others, name only the one you need: `Validation` already gives
you `Translation` and `Filesystem`.

`Events` prefers the application's own `App\Providers\EventServiceProvider`, since that is
what maps its listeners. Laravel 11 and later do not ship one by default; when it is
absent the concern falls back to the framework's `Illuminate\Events\EventServiceProvider`,
which binds the dispatcher and nothing else — enough for a test that registers its own
listeners or only asserts on `Event::fake()`.

Override `eventServiceProvider()` to point at a provider kept somewhere else, or to force
the framework's when the application's own pulls in bindings a partial boot cannot give it:

```php
protected function eventServiceProvider(): ServiceProvider
{
    return new \Illuminate\Events\EventServiceProvider($this->app);
}
```

## The refusals

These exist to fail fast with `FullBootRequired`, telling you the test belongs on the
full `TestCase`:

| Concern | Because |
| --- | --- |
| `RefreshDatabase` | `refreshDatabase()` calls `$this->artisan()`, which boots everything |
| `DatabaseMigrations` | same |
| `Routes` | `$this->get()` and friends boot everything |
| `Console` | `$this->artisan()` boots everything |
| `WithoutMiddleware` | only meaningful for a request the full boot serves |
