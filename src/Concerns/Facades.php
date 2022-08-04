<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Bootstrap\RegisterFacades;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Facade;

trait Facades
{
    protected function setUpFacades()
    {
        (new RegisterFacades())->bootstrap($this->app);
    }
}
