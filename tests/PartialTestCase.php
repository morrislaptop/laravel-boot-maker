<?php

namespace Morrislaptop\LaravelBootMaker\Tests;

use Morrislaptop\LaravelBootMaker\PartialTestCase as BasePartialTestCase;

class PartialTestCase extends BasePartialTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../laravel/bootstrap/app.php';

        // $app->make(Kernel::class)->bootstrap(); // Don't bootstrap automatically...

        return $app;
    }
}
