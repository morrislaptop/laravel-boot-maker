<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Facade;

trait Facades
{
    protected function setUpFacades()
    {
        Facade::setFacadeApplication($this->app);
        App::setFacadeApplication($this->app);
    }
}
