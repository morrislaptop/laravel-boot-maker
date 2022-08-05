<?php

namespace Morrislaptop\LaravelBootMaker\Tests;

use App\Providers\EventServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class FullTestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            EventServiceProvider::class,
        ];
    }
}
