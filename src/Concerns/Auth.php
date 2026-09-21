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

        // The session guard needs these.
        $this->setUpSetRequestForConsole();
        $this->app->register(new CookieServiceProvider($this->app));
        $this->app->register(new SessionServiceProvider($this->app));

        $this->app->register(new AuthServiceProvider($this->app));

        // `StartSession` never runs: middleware is off.
        $this->app->rebinding('request', fn ($app, $request) => $request->setLaravelSession($app['session.store']));
    }
}
