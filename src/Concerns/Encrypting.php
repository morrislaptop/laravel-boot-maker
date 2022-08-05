<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Encryption\EncryptionServiceProvider;

trait Encrypting
{
    use Config;

    protected function setUpEncrypting()
    {
        $provider = new EncryptionServiceProvider($this->app);
        $this->app->register($provider);
    }
}
