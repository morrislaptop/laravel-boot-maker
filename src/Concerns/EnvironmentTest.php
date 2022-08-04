<?php
namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use Illuminate\Support\Facades\Cache as CacheFacade;
use Illuminate\Support\Facades\Event;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class EnvironmentTest extends PartialTestCase
{
    use Environment;

    public function test_it_can_test_environment()
    {
        $this->assertEquals(42, env('FROM_ENV_TESTING'));
    }
}
