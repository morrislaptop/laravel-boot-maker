<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;

trait Config
{
    protected function bootConfig()
    {
        $booter = new LoadConfiguration();
        $booter->bootstrap($this->app);
    }
}
