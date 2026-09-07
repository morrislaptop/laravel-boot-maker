<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Providers\EventServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Events\EventServiceProvider as FrameworkEventServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Support\ServiceProvider;

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

        $events = $this->eventServiceProvider();
        $this->app->register($events);
        $events->callBootingCallbacks();
    }

    /**
     * The application's own EventServiceProvider is what maps its listeners and
     * subscribers, so prefer it. Laravel 11 and later do not ship one, and an
     * application is free to put its own elsewhere, so fall back to the framework's:
     * that binds the dispatcher, which is enough for a test that registers its
     * listeners itself or only asserts on `Event::fake()`.
     *
     * Override this to return a provider that lives somewhere else, or to force the
     * framework's when the application's is too heavy for a partial boot.
     */
    protected function eventServiceProvider(): ServiceProvider
    {
        $provider = class_exists(EventServiceProvider::class)
            ? EventServiceProvider::class
            : FrameworkEventServiceProvider::class;

        return new $provider($this->app);
    }
}
