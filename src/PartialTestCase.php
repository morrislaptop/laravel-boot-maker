<?php

namespace Morrislaptop\LaravelBootMaker;

use PHPUnit\Framework\TestCase;

class PartialTestCase extends TestCase
{
    protected function setUp(): void
    {
        Facade::clearResolvedInstances();

        if (! $this->app) {
            $this->refreshApplication();

            ParallelTesting::callSetUpTestCaseCallbacks($this);
        }

        $this->setUpTraits();

        foreach ($this->afterApplicationCreatedCallbacks as $callback) {
            $callback();
        }

        Model::setEventDispatcher($this->app['events']);

        $this->setUpHasRun = true;
    }
}
