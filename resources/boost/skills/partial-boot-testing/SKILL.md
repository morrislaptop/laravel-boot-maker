---
name: partial-boot-testing
description: Speed up slow PHPUnit or Pest tests by booting only the parts of Laravel a test actually needs, using laravel-boot-maker's PartialTestCase and concern traits. Use when a test suite is slow, when a unit test extends the app's full TestCase but never touches the database, when writing a new test for a value object, enum, cast, DTO, service, listener, job, rule or notification, or when the user mentions laravel-boot-maker, PartialTestCase, partial boot, FullBootRequired, or slow tests.
---

# Partial boot testing

A Laravel app registers every service provider on boot. For a test that only reads
config or formats a date, that boot *is* the cost — often 10 to 20 times the test
itself.

`PartialTestCase` builds `bootstrap/app.php` but never bootstraps it. The test then
names the pieces it needs with a concern trait. Nothing else loads.

## Quick start

One-time setup — a base class in the application's test suite:

```php
namespace Tests;

use Illuminate\Foundation\Application;
use Morrislaptop\LaravelBootMaker\PartialTestCase as BasePartialTestCase;

abstract class PartialTestCase extends BasePartialTestCase
{
    public function createApplication(): Application
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
```

Then per test:

```php
use Morrislaptop\LaravelBootMaker\Concerns\Translation;
use Tests\PartialTestCase;

final class PaymentTypeTest extends PartialTestCase
{
    use Translation;   // the translator boots; nothing else does
}
```

## Converting an existing test

Work one file at a time. Do not guess the concerns up front — let the failure name them.

1. Swap the parent class to `PartialTestCase` and add **no** concerns.
2. Run just that file: `vendor/bin/phpunit path/to/FooTest.php`
3. Read the error and add the one concern it names. See [CONCERNS.md](CONCERNS.md)
   for the error-to-concern table and what each concern registers.
4. Repeat. **Add the fewest concerns that make it pass** — every extra one is boot
   time back.
5. Stop after about four attempts. Some tests need the whole framework; that is a
   fine answer, revert the file and move on.
6. Compare the `Time:` line before and after. Keep the change only if it is faster.

## When a test cannot be converted

Three things stay on the full `TestCase`: a test asserting on **middleware** (auth
redirects, throttling, CSRF), a test reading the **schedule**, and code reaching a binding
only an application or package provider registers when that provider cannot be built
partially — a model calling into Nova, a Filament/Livewire page. Try listing the provider
in `additionalProviders()` first.

Everything else has a concern, including HTTP requests (`Routes`), authentication (`Auth`),
commands (`Console`) and migrations (`RefreshDatabase`, `DatabaseMigrations`). A command
test must name its command in `consoleCommands()`.

Helpers are a subtler blocker: a helper method defined on the app's own `TestCase` is
unreachable from `PartialTestCase`. Move it into a trait both can use, rather than
copying it.

## Two things that surprise people

- **Deprecations appear.** The full boot installs `HandleExceptions`, whose error
  handler swallows PHP deprecations. A partial boot has no such handler, so real
  pre-existing deprecations in the source become visible. Fix the source; they were
  not caused by the conversion.
- **A 500 in a route test does not look like one.** The application's error page still
  renders, so a test that never asserts a status fails later on a confusing assertion.
  Assert `->assertOk()` first while converting, and `dump()` the response to see the
  real cause.
- **`Database` is what binds Faker.** `DatabaseServiceProvider` binds
  `Faker\Generator`, so a model factory failing with `Unknown format "uuid"` needs
  `Database`, not `WithFaker`.
