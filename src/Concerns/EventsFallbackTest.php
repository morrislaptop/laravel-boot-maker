<?php

use Illuminate\Events\EventServiceProvider as FrameworkEventServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

/**
 * The fixture application defines App\Providers\EventServiceProvider, so the override
 * below stands in for an application that does not — Laravel 11 and later, or one that
 * keeps its provider elsewhere. What has to hold there is that the dispatcher is still
 * bound and usable.
 */
class EventsFallbackTest extends PartialTestCase
{
    use Events;

    public function test_it_dispatches_when_the_application_has_no_event_service_provider()
    {
        $heard = false;

        Event::listen('question.created', function () use (&$heard): void {
            $heard = true;
        });

        Event::dispatch('question.created');

        $this->assertTrue($heard);
    }

    protected function eventServiceProvider(): ServiceProvider
    {
        return new FrameworkEventServiceProvider($this->app);
    }
}
