<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Testing\WithFaker as TestingWithFaker;

trait WithFaker
{
    use Config, TestingWithFaker;

    protected function setUpWithFaker()
    {
        $this->setUpFaker();
    }
}
