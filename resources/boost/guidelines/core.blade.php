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
- `RefreshDatabase`, `DatabaseMigrations`, `Routes`, `Console` and `WithoutMiddleware`
  throw `FullBootRequired` on purpose. A test needing one of those stays on the full
  `TestCase`.

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
concern the error names. Use the `partial-boot-testing` skill for the full workflow and
the error-to-concern table.
