<?php

namespace Morrislaptop\LaravelBootMaker\Tests;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Morrislaptop\LaravelBootMaker\Concerns\Database;

class FacadeAliasCollisionTest extends PartialTestCase
{
    use Database;

    public function test_it_reports_the_missing_binding_a_global_facade_alias_hides()
    {
        // What a full boot's AliasLoader leaves behind for the rest of the process.
        class_exists('Auth', autoload: false) || class_alias(AuthFacade::class, 'Auth');

        $this->expectException(BindingResolutionException::class);

        AuthFacade::guard();
    }
}
