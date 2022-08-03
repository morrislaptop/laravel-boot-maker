<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Cache\CacheServiceProvider;

trait Cache
{
    use Config;

    protected function bootCache()
    {
        $provider = new CacheServiceProvider($this->app);
        $provider->register();
    }
}
