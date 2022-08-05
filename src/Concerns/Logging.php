<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Log\LogServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Queue\QueueServiceProvider;

trait Logging
{
    use Config;

    protected function setUpLogging()
    {
        $provider = new LogServiceProvider($this->app);
        $this->app->register($provider);
    }
}
