<?php

use Illuminate\Support\Facades\Cache;
use Morrislaptop\LaravelBootMaker\Tests\FullTestCase;

/**
 * Use this scratch pad to test "full" Laravel features, then
 * copy over to the relevant Concern test to see if it
 * works in isolation.
 */
class ScratchPadFullTest extends FullTestCase
{
    public function test_works()
    {
        Cache::put('question', 42);
        $this->assertEquals(42, Cache::get('question'));
    }
}
