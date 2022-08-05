<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class TranslationTest extends PartialTestCase
{
    use Translation;

    public function test_it_can_test_translations()
    {
        $this->assertEquals('Welcome to our application!', __('messages.welcome'));
    }
}
