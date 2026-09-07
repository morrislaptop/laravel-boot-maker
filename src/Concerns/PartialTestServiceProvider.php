<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\ServiceProvider;

class PartialTestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->instance('partial-test-provider-booted', true);
    }
}
