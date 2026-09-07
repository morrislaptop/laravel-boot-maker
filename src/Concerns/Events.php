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

        // eventServiceProvider() lives on PartialTestCase because a trait method wins
        // over an inherited one, so an override here would silently lose.
        $events = $this->eventServiceProvider();
        $this->app->register($events);
        $events->callBootingCallbacks();
    }
}
