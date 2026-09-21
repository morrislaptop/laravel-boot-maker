## Laravel Boot Maker

This package boots only the parts of Laravel a test needs, instead of registering every
service provider. Boot is most of what a unit test costs, so this is usually a 10x to 20x
saving on a test that never touches the database.

### Conventions

- Tests extend the application's own `Tests\PartialTestCase`, which extends
  `Morrislaptop\LaravelBootMaker\PartialTestCase` and returns `bootstrap/app.php` from
  `createApplication()` without bootstrapping it.
- Each test names the pieces it needs with a concern trait from
  `Morrislaptop\LaravelBootMaker\Concerns\`. Use the fewest that make it pass.
- Requests, auth, commands and migrations have concerns: `Routes`, `Auth`, `Console`,
  `RefreshDatabase`, `DatabaseMigrations`.
- Only `Routes`, `Console` and `AdditionalProviders` register `additionalProviders()`.
  Use `AdditionalProviders` when the test makes no request and runs no command.
- `Database` alone does not roll back. A test that writes uses `DatabaseTransactions`
  or `RefreshDatabase`. Both include `Database`.
- `Routes` runs no middleware. Middleware tests stay on the full `TestCase`.

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
concern the error names. Then run the whole suite: a file that passes alone can fail
among the rest. Use the `partial-boot-testing` skill for the
full workflow and the error-to-concern table.
