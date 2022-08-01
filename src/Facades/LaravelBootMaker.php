<?php

namespace Morrislaptop\LaravelBootMaker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Morrislaptop\LaravelBootMaker\LaravelBootMaker
 */
class LaravelBootMaker extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Morrislaptop\LaravelBootMaker\LaravelBootMaker::class;
    }
}
