<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use BadMethodCallException;
use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;

trait Console
{
    public function setUpConsole() {
        throw new BadMethodCallException('Testing console commands requires booting the whole framework.');
    }
}
