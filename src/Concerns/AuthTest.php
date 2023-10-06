<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\Facades\Auth as AuthFacade;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class AuthTest extends PartialTestCase
{
    use Auth;

    public function test_it_can_test_auth()
    {
        $this->assertInstanceOf(\Illuminate\Auth\AuthManager::class, auth());
    }
}
