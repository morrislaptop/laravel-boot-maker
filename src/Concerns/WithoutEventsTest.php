<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use Illuminate\Support\Facades\Event;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class WithoutEventsTest extends PartialTestCase
{
    use Events;
    use WithoutEvents;

    protected function setUpTraits()
    {
        if (version_compare(app()->version(), '10', '>=')) {
            $this->markTestSkipped('WithoutEvents removed in Laravel 10. https://laravel.com/docs/10.x/upgrade#service-mocking');
        }

        parent::setUpTraits();
    }

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
