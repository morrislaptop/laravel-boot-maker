<?php

namespace Morrislaptop\LaravelBootMaker;

use Illuminate\Foundation\Bootstrap\RegisterFacades;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;
use Tests\CreatesPartialApplication;

abstract class PartialTestCase extends TestCase
{
    protected function refreshApplication()
    {
        parent::refreshApplication();

        Facade::setFacadeApplication($this->app);
    }
}
