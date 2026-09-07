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

These concerns throw `FullBootRequired` deliberately: `RefreshDatabase`,
`DatabaseMigrations`, `Routes`, `Console`, `WithoutMiddleware`. A test that needs one
of them stays on the full `TestCase`.

In practice that means anything which calls `route()` or generates a URL, sends an
HTTP request, runs `$this->artisan()`, reads or writes real rows, renders a
Filament/Livewire/Nova page, or resolves a binding that only an application service
provider registers. Roughly a quarter of candidates fall here.

Helpers are a subtler blocker: a helper method defined on the app's own `TestCase` is
unreachable from `PartialTestCase`. Move it into a trait both can use, rather than
copying it.

## Two things that surprise people

- **Deprecations appear.** The full boot installs `HandleExceptions`, whose error
  handler swallows PHP deprecations. A partial boot has no such handler, so real
  pre-existing deprecations in the source become visible. Fix the source; they were
  not caused by the conversion.
- **`Database` is what binds Faker.** `DatabaseServiceProvider` binds
  `Faker\Generator`, so a model factory failing with `Unknown format "uuid"` needs
  `Database`, not `WithFaker`.
