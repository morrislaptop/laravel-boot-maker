<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;

trait Events
{
    protected function setUpEvents()
    {
        // load these providers directly instead of traits
        // as the traits load Config as well, which
        // isn't required for Events.
        $files = new FilesystemServiceProvider($this->app);
        $this->app->register($files);

        $cache = new CacheServiceProvider($this->app);
        $this->app->register($cache);

        // Not defined here: a trait method would win over the user's override.
        $events = $this->eventServiceProvider();
        $this->app->register($events);
        $events->callBootingCallbacks();
    }
}
