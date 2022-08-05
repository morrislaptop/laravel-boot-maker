<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\Facades\Crypt;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class EncryptingTest extends PartialTestCase
{
    use Encrypting;

    public function test_it_can_test_encrypting()
    {
        $encrypted = Crypt::encryptString('42');

        $this->assertEquals('42', Crypt::decryptString($encrypted));
    }
}
