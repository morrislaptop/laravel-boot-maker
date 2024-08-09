<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Bootstrap\RegisterFacades;

trait Facades
{
    protected function setUpFacades()
    {
        (new RegisterFacades)->bootstrap($this->app);
    }
}
