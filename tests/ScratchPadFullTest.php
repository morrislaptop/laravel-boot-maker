<?php

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\FullTestCase;

/**
 * Use this scratch pad to test "full" Laravel features, then
 * copy over to the relevant Concern test to see if it
 * works in isolation.
 */
class ScratchPadFullTest extends FullTestCase
{
    function test_works()
    {
        Cache::put('question', 42);
        $this->assertEquals(42, Cache::get('question'));
    }
}
