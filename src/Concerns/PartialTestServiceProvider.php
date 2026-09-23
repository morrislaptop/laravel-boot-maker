<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\ServiceProvider;

class PartialTestServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance('partial-test-provider-registered', true);
    }

    /** Counted, to prove it boots once. */
    public function boot()
    {
        $this->app->instance('partial-test-provider-booted', $this->app->bound('partial-test-provider-booted')
            ? $this->app['partial-test-provider-booted'] + 1
            : 1);
    }
}
