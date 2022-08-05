<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Filesystem\FilesystemServiceProvider;

trait Filesystem
{
    use Config;

    protected function setUpFilesystem()
    {
        $provider = new FilesystemServiceProvider($this->app);
        $this->app->register($provider);
    }
}
