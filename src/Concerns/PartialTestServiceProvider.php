<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\ServiceProvider;

class PartialTestServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance('partial-test-provider-registered', true);
    }

    /** Counted, so a test using two concerns that register providers can prove it ran once. */
    public function boot()
    {
        $this->app->instance('partial-test-provider-booted', $this->app->bound('partial-test-provider-booted')
            ? $this->app['partial-test-provider-booted'] + 1
            : 1);
    }
}
