<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Testing\WithoutEvents as TestingWithoutEvents;

trait WithoutEvents
{
    use TestingWithoutEvents;

    protected function setUpWithoutEvents()
    {
        $this->disableEventsForAllTests();
    }
}
