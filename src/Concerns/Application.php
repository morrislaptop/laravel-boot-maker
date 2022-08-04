<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Contracts\Foundation\Application as BaseApplication;
use Illuminate\Support\Facades\App;

trait Application
{
    use Facades;

    protected BaseApplication $app;

    protected function setUpApplication()
    {
        // @todo - ensure method exists via trait in app space.
        $this->app = $this->createPartialApplication();

        App::swap($this->app);
    }
}
