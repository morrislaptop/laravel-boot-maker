<?php

namespace Morrislaptop\LaravelBootMaker\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Application;
use Morrislaptop\LaravelBootMaker\LaravelBootMakerServiceProvider;
use Morrislaptop\LaravelBootMaker\PartialTestCase as BasePartialTestCase;
use Orchestra\Testbench\TestCase as Orchestra;

class PartialTestCase extends BasePartialTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../laravel/bootstrap/app.php';

        // $app->make(Kernel::class)->bootstrap(); // Don't bootstrap automatically...

        return $app;
    }
}
