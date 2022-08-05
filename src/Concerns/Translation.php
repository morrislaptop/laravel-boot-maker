<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

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
