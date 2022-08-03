<?php

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

uses(
    PartialTestCase::class,
    Events::class
);

it('can test cache stuff', function () {
    Cache::put('question', 42);
    expect(Cache::get('question'))->toBe(42);
});
