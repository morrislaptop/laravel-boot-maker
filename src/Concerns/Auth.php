<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Auth\AuthServiceProvider;

trait Auth
{
    use Config;

    protected function setUpAuth()
    {
        $provider = new AuthServiceProvider($this->app);
        $this->app->register($provider);
    }
}
