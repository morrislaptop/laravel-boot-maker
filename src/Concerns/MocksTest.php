<?php

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use App\Service;
use Illuminate\Support\Facades\Event;
use Mockery\MockInterface;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Concerns\Mocks;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

uses(
    PartialTestCase::class,
    Mocks::class
);

it('can test mocking', function () {
    $this->mock(Service::class, function (MockInterface $mock) {
        $mock->shouldReceive('process')->once();
    });

    $service = resolve(Service::class);
    // $service->process();
});
