<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class AuthTest extends PartialTestCase
{
    use Auth;

    public function test_it_can_act_as_a_user()
    {
        $user = new User(['name' => 'Bob']);

        $this->actingAs($user);

        $this->assertTrue(AuthFacade::check());
        $this->assertSame($user, AuthFacade::user());
    }
}
