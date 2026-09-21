<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

trait AdditionalProviders
{
    // Providers often use the request and facades when they boot.
    use Config, Facades, SetRequestForConsole;

    protected function setUpAdditionalProviders()
    {
        $this->registerAdditionalProviders();
    }
}
