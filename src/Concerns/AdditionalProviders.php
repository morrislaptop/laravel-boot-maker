<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

trait AdditionalProviders
{
    // Application and package providers routinely reach for the request and facades while booting.
    use Config, Facades, SetRequestForConsole;

    protected function setUpAdditionalProviders()
    {
        $this->registerAdditionalProviders();
    }
}
