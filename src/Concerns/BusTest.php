<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Jobs\ShipOrder;
use Illuminate\Support\Facades\Bus as BusFacade;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class BusTest extends PartialTestCase
{
    use Bus;

    public function test_it_can_test_bus()
    {
        BusFacade::fake();

        ShipOrder::dispatch();

        BusFacade::assertDispatched(ShipOrder::class);
    }
}
