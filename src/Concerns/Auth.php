<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Auth\AuthServiceProvider;
use Illuminate\Cookie\CookieServiceProvider;
use Illuminate\Session\SessionServiceProvider;

trait Auth
{
    use Config, Events, Hashing, SetRequestForConsole;

    protected function setUpAuth()
    {
        $this->setUpEvents();
        $this->setUpHashing();

        // The session guard reads the user off the request and the session, and writes
        // the remember me token to a cookie.
        $this->setUpSetRequestForConsole();
        $this->app->register(new CookieServiceProvider($this->app));
        $this->app->register(new SessionServiceProvider($this->app));

        $this->app->register(new AuthServiceProvider($this->app));
    }
}
