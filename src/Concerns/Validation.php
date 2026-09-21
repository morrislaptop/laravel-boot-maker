<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Providers\FormRequestServiceProvider;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider;

trait Validation
{
    use Translation;

    protected function setUpValidation()
    {
        $validation = new ValidationServiceProvider($this->app);
        $validation->register();

        // `$request->validate()`, and form requests that validate themselves.
        (new FoundationServiceProvider($this->app))->register();
        $this->bootProvider($this->app->register(FormRequestServiceProvider::class));
    }
}
