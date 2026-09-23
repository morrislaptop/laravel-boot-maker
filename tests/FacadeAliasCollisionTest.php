<?php

namespace Morrislaptop\LaravelBootMaker\Tests;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Fluent;
use Morrislaptop\LaravelBootMaker\Concerns\Database;

class FacadeAliasCollisionTest extends PartialTestCase
{
    use Database;

    public function test_it_reports_the_missing_binding_a_global_facade_alias_hides()
    {
        // What an earlier full boot leaves behind.
        class_exists('Auth', autoload: false) || class_alias(AuthFacade::class, 'Auth');

        $this->expectException(BindingResolutionException::class);

        AuthFacade::guard();
    }

    public function test_it_reports_a_missing_binding_that_names_a_global_class()
    {
        // What phpredis defines.
        class_exists('Redis') || class_alias(Fluent::class, 'Redis');

        $this->expectException(BindingResolutionException::class);

        $this->app->make('redis');
    }
}
