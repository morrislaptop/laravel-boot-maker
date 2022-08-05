<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider;

trait Validation
{
    use Translation;

    protected function setUpValidation()
    {
        $translation = new ValidationServiceProvider($this->app);
        $translation->register();
    }
}
