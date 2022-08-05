<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\View\ViewServiceProvider;

trait Views
{
    use Filesystem;

    protected function setUpViews()
    {
        $provider = new ViewServiceProvider($this->app);
        $this->app->register($provider);
    }
}
