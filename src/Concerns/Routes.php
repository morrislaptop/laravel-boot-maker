<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;

trait Routes
{
    use Config, SetRequestForConsole;

    protected function setUpRoutes()
    {
        // $this->get() boots the framework.
        throw new FullBootRequired('Testing routes requires booting the whole framework.');
    }
}
