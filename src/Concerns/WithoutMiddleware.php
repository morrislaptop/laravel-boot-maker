<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Testing\WithoutMiddleware as TestingWithoutMiddleware;
use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;

trait WithoutMiddleware
{
    use TestingWithoutMiddleware;

    protected function setUpWithoutMiddleware()
    {
        throw new FullBootRequired('WithoutMiddleware requires booting the whole framework.');
    }
}
