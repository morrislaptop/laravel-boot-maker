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

        // Registers the `$request->validate()` macro. The form request provider it
        // brings installs the hook that validates an injected form request in its
        // boot(), and without that a controller receives one unvalidated.
        (new FoundationServiceProvider($this->app))->register();
        $this->bootProvider($this->app->register(FormRequestServiceProvider::class));
    }
}
