<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

trait Environment
{
    protected function setUpEnvironment()
    {
        (new LoadEnvironmentVariables)->bootstrap($this->app);
    }
}
