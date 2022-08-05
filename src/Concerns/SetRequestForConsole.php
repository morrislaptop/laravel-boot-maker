<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Foundation\Bootstrap\SetRequestForConsole as BootstrapSetRequestForConsole;

trait SetRequestForConsole
{
    protected function setUpSetRequestForConsole()
    {
        $booter = new BootstrapSetRequestForConsole();
        $booter->bootstrap($this->app);
    }
}
