<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Cache\CacheServiceProvider;

trait Cache
{
    use Config;

    protected function setUpCache()
    {
        $cache = new CacheServiceProvider($this->app);
        $this->app->register($cache);
    }
}
