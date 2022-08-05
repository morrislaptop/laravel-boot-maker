<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use Illuminate\Support\Facades\Event;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class WithoutEventsTest extends PartialTestCase
{
    use Events;
    use WithoutEvents;

    public function test_it_can_test_without_events()
    {
        $answer = null;

        Event::listen(QuestionCreated::class, function () use (&$answer) {
            $answer = 42;
        });

        event(new QuestionCreated());

        $this->assertNull($answer);
    }
}
