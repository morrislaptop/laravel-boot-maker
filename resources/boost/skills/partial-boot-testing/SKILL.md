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
7. Run the **whole suite in one process** before keeping the conversion. A file that
   passes alone can fail among the rest: an earlier full boot leaves global state
   behind, and a `Database` test without a transaction leaves rows behind.

The suite gains less than one converted file does, because the slowest files are
usually the ones that cannot convert. Report the suite time.

## When a test cannot be converted

These stay on the full `TestCase`:

- a test of **middleware** (auth redirects, throttling, CSRF)
- a test of the **schedule**
- code that needs a provider which cannot boot partially, for example Nova, Filament or
  Livewire. Try `additionalProviders()` first.

The application's shape can also block a file:

- **A shared base test class.** Convert the base and all its tests, or none.
- **Helpers on the app's own `TestCase`.** Move them into a trait both base classes use.
  This includes `setUp()` code that resets static state. Without it, tests leak state.

## Things that surprise people

- **Deprecations appear.** A full boot hides PHP deprecations. A partial boot does not.
  They are real. Fix the source.
- **A 500 in a route test looks like a different failure.** Assert `->assertOk()` first
  while converting, and `dump()` the response to see the cause.
- **`Database` alone does not roll back.** A test that writes keeps its rows, and the
  next test sees them. Use `DatabaseTransactions` or `RefreshDatabase`.
- **`Database` binds Faker.** A factory failing with `Unknown format "uuid"` needs
  `Database`, not `WithFaker`.
