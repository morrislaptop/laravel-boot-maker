<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

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
