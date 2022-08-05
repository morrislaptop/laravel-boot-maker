<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Translation\TranslationServiceProvider;

trait Translation
{
    use Filesystem;

    protected function setUpTranslation()
    {
        $translation = new TranslationServiceProvider($this->app);
        $translation->register();
    }
}
