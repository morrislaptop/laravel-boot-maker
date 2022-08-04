<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Support\Str;
use Mockery;
use Mockery\Exception\InvalidCountException;

trait Mocks
{
    use Application, InteractsWithContainer;

    public function tearDownMocks()
    {
        if (class_exists('Mockery')) {
            if ($container = Mockery::getContainer()) {
                $this->addToAssertionCount($container->mockery_getExpectationCount());
            }

            try {
                Mockery::close();
            } catch (InvalidCountException $e) {
                if (! Str::contains($e->getMethodName(), ['doWrite', 'askQuestion'])) {
                    throw $e;
                }
            }
        }
    }
}
