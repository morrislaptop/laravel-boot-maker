<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;

trait Console
{
    public function setUpConsole()
    {
        // Calls to $this->artisan() boot the whole framework
        throw new FullBootRequired('Testing console commands requires booting the whole framework.');
    }
}
