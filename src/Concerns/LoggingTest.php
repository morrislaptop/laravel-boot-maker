<?php
namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use Illuminate\Support\Facades\Cache as CacheFacade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class LoggingTest extends PartialTestCase
{
    use Logging;

    public function test_it_can_test_logs()
    {
        $this->assertNull(Log::info('Does this work?'));
    }
}
