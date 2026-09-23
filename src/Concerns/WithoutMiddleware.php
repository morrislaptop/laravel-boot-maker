<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Testing\WithoutMiddleware as TestingWithoutMiddleware;

trait WithoutMiddleware
{
    use TestingWithoutMiddleware;

    protected function setUpWithoutMiddleware()
    {
        $this->withoutMiddleware();
    }
}
