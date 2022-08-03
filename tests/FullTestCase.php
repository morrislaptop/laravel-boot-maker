<?php

namespace Morrislaptop\LaravelBootMaker\Tests;

use App\Providers\EventServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Morrislaptop\LaravelBootMaker\LaravelBootMakerServiceProvider;
use Morrislaptop\LaravelBootMaker\PartialTestCase;

class FullTestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            EventServiceProvider::class,
        ];
    }
}
