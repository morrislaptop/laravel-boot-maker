<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Cache\CacheServiceProvider;

trait Cache
{
    use Config;

    protected function setUpCache()
    {
        $provider = new CacheServiceProvider($this->app);
        $provider->register();
    }
}
