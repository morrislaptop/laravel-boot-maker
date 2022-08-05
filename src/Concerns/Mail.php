<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Mail\MailServiceProvider;
use Illuminate\Queue\QueueServiceProvider;

trait Mail
{
    use Config, Views;

    protected function setUpMail()
    {
        $provider = new MailServiceProvider($this->app);
        $this->app->register($provider);
    }
}
