<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Bus\BusServiceProvider;
use Illuminate\Queue\QueueServiceProvider;

trait Bus
{
    protected function setUpBus()
    {
        $provider = new BusServiceProvider($this->app);
        $this->app->register($provider);
    }
}
