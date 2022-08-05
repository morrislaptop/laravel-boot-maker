<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Jobs\ShipOrder;
use Illuminate\Support\Facades\Queue;
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
