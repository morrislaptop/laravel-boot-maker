## Laravel Boot Maker

This package boots only the parts of Laravel a test needs, instead of registering every
service provider. Boot is most of what a unit test costs, so a converted file usually runs
3x to 10x faster.

### Conventions

- Tests extend the application's own `Tests\PartialTestCase`, which extends
  `Morrislaptop\LaravelBootMaker\PartialTestCase` and returns `bootstrap/app.php` from
  `createApplication()` without bootstrapping it.
- Each test names the pieces it needs with a concern trait from
  `Morrislaptop\LaravelBootMaker\Concerns\`. Use the fewest that make it pass.
- HTTP requests, authentication, artisan commands and migrations all work partially
  booted: `Routes`, `Auth`, `Console`, `RefreshDatabase`, `DatabaseMigrations`.
- `Routes`, `Console` and `AdditionalProviders` register `additionalProviders()`. A test
  needing a package's binding but making no request uses `AdditionalProviders`.
- `Database` on its own commits. Pair it with `DatabaseTransactions` or `RefreshDatabase`
  unless the test only reads.
- `Routes` runs no middleware. A test asserting on middleware behaviour, or on a
  binding only a full boot can build, stays on the full `TestCase`.

@verbatim
<code-snippet name="A test that only needs the translator" lang="php">
use Morrislaptop\LaravelBootMaker\Concerns\Translation;
use Tests\PartialTestCase;

final class PaymentTypeTest extends PartialTestCase
{
    use Translation;
}
</code-snippet>
@endverbatim

When converting an existing test, add no concerns first, run the file, and add the one
concern the error names. Then run the whole suite in one process: a converted file that
passes alone can still fail among the rest. Use the `partial-boot-testing` skill for the
full workflow and the error-to-concern table.
