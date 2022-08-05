<?php
namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use App\Jobs\ShipOrder;
use App\Listeners\AskQuestion;
use Illuminate\Support\Facades\Cache as CacheFacade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class QueuesTest extends PartialTestCase
{
    use Queues;

    public function test_it_can_test_queue()
    {
        Queue::fake();

        ShipOrder::dispatch();

        Queue::assertPushed(ShipOrder::class);
    }
}
