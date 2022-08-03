<?php

namespace Morrislaptop\LaravelBootMaker;

use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Tests\CreatesPartialApplication;

class PartialTestCase extends TestCase
{
    private const ExpectedTraitBootOrder = [
        Concerns\Application::class,
        Concerns\Facades::class,
        Concerns\Filesystem::class,
        // LaravelConfig::class,
        // LaravelTranslator::class,
        // SquireCountries::class,
    ];

    protected function setUp(): void
    {
        $this->createPartialApplication();
        $this->bootConcerns();

        // Facade::clearResolvedInstances();

        // if (! $this->app) {
        //     $this->refreshApplication();

        //     ParallelTesting::callSetUpTestCaseCallbacks($this);
        // }

        // $this->setUpTraits();

        // foreach ($this->afterApplicationCreatedCallbacks as $callback) {
        //     $callback();
        // }

        // Model::setEventDispatcher($this->app['events']);

        // $this->setUpHasRun = true;
    }

    protected function bootConcerns()
    {
        $preferredOrder = array_flip(self::ExpectedTraitBootOrder);

        collect(class_uses_recursive(static::class))
            ->sortBy(fn (string $trait) => $preferredOrder[$trait] ?? INF)
            ->map(fn (string $trait) => (string) Str::of($trait)->afterLast('\\')->prepend('boot'))
            ->filter(fn (string $method) => method_exists($this, $method))
            // ->dump()
            ->each(fn (string $method) => $this->$method());
    }
}
