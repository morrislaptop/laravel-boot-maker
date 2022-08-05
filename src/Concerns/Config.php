<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Bootstrap\LoadConfiguration;

trait Config
{
    protected function setUpConfig()
    {
        $booter = new LoadConfiguration();
        $booter->bootstrap($this->app);
    }
}
