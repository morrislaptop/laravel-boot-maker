<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Cache\CacheServiceProvider;

trait Cache
{
    protected function bootCache()
    {
        $provider = new CacheServiceProvider($this->app);
        $provider->register();
    }
}
