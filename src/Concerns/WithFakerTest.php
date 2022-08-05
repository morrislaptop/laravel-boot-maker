<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class WithFakerTest extends PartialTestCase
{
    use WithFaker;

    public function test_it_can_test_faker()
    {
        $this->assertNotEmpty($this->faker->name);
    }
}
