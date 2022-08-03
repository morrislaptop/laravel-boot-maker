<?php

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use Illuminate\Support\Facades\Event;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\FullTestCase;

uses(
    FullTestCase::class,
);

/**
 * Use this scratch pad to test "full" Laravel features, then
 * copy over to the relevant Concern test to see if it
 * works in isolation.
 */
it('works with a fully buited Laravel', function () {
    Event::fake();
    Event::assertListening(QuestionCreated::class, AskQuestion::class);
});
