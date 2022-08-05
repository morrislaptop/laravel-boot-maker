<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\Facades\Hash;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class HashingTest extends PartialTestCase
{
    use Hashing;

    public function test_it_can_test_hash()
    {
        $this->assertNotEmpty(Hash::make('testing'));
    }
}
