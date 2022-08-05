<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Queue\QueueServiceProvider;

trait Hashing
{
    use Config;

    protected function setUpHashing()
    {
        $provider = new HashServiceProvider($this->app);
        $this->app->register($provider);
    }
}
