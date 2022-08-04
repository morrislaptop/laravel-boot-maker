<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Filesystem\FilesystemServiceProvider;

trait Filesystem
{
    protected function setUpFilesystem()
    {
        $provider = new FilesystemServiceProvider($this->app);
        $provider->register();
    }
}
