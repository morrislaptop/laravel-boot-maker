<?php

namespace Morrislaptop\LaravelBootMaker\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Application;
use Morrislaptop\LaravelBootMaker\LaravelBootMakerServiceProvider;
use Morrislaptop\LaravelBootMaker\PartialTestCase as BasePartialTestCase;
use Orchestra\Testbench\TestCase as Orchestra;

class PartialTestCase extends BasePartialTestCase
{
    protected function createPartialApplication()
    {
        $basePath = realpath(__DIR__.'/..');

        return new Application($basePath);
    }
}
