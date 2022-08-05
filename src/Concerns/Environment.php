<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

trait Environment
{
    protected function setUpEnvironment()
    {
        (new LoadEnvironmentVariables)->bootstrap($this->app);
    }
}
