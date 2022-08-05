<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Notifications\NotificationServiceProvider;

trait Notifications
{
    // use Config, Views;

    protected function setUpNotifications()
    {
        $provider = new NotificationServiceProvider($this->app);
        $this->app->register($provider);
    }
}
