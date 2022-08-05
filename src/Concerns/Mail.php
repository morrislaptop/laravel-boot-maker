<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Mail\MailServiceProvider;

trait Mail
{
    use Config, Views;

    protected function setUpMail()
    {
        $provider = new MailServiceProvider($this->app);
        $this->app->register($provider);
    }
}
