<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Log\LogServiceProvider;

trait Logging
{
    use Config;

    protected function setUpLogging()
    {
        $provider = new LogServiceProvider($this->app);
        $this->app->register($provider);
    }
}
