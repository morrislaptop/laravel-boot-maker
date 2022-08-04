<?php

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use App\Service;
use Illuminate\Support\Facades\Event;
use Mockery\MockInterface;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Concerns\Mocks;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class MocksTest extends PartialTestCase
{
    use Mocks;

    public function test_it_can_mock()
    {
        $this->mock(Service::class, function (MockInterface $mock) {
            $mock->shouldReceive('process')->once();
        });

        $service = resolve(Service::class);
        $service->process();
    }
}
