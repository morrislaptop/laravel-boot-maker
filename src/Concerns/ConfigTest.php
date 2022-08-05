<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class ConfigTest extends PartialTestCase
{
    use Config;

    public function test_it_can_test_config()
    {
        $this->assertEquals('Laravel', config('app.name'));
    }
}
