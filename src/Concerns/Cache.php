<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;

trait Cache
{
    use Config;

    protected function setUpCache()
    {
        $files = new FilesystemServiceProvider($this->app);
        $this->app->register($files);

        $cache = new CacheServiceProvider($this->app);
        $cache->register();
    }
}
