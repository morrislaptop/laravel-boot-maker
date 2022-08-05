<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class EnvironmentTest extends PartialTestCase
{
    use Environment;

    public function test_it_can_test_environment()
    {
        $this->assertEquals(42, env('FROM_ENV_TESTING'));
    }
}
