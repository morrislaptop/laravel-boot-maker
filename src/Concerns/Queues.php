<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Queue\QueueServiceProvider;

trait Queues
{
    use Bus;

    protected function setUpQueues()
    {
        $provider = new QueueServiceProvider($this->app);
        $this->app->register($provider);
    }
}
