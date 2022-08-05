<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Mail\MailServiceProvider;
use Illuminate\Notifications\NotificationServiceProvider;
use Illuminate\Queue\QueueServiceProvider;

trait Notifications
{
    // use Config, Views;

    protected function setUpNotifications()
    {
        $provider = new NotificationServiceProvider($this->app);
        $this->app->register($provider);
    }
}
