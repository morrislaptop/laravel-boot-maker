<?php

use Illuminate\Support\Facades\Event;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\FullTestCase;

uses(
    FullTestCase::class,
    // Events::class
);

it('can test events stuff', function () {
    Event::fake();
    Event::assertListening(QuestionCreated::class, AskQuestion::class);
});
