<?php

namespace Morrislaptop\LaravelBootMaker;

use Illuminate\Foundation\Bootstrap\RegisterFacades;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;
use Tests\CreatesPartialApplication;

abstract class PartialTestCase extends TestCase
{
    private const concernOrder = [
        Concerns\Environment::class,
        Concerns\Config::class,
        Concerns\Exceptions::class,
        Concerns\Facades::class,
    ];

    protected function refreshApplication()
    {
        parent::refreshApplication();

        Facade::setFacadeApplication($this->app);
    }

    protected function setUpTraits()
    {
        $preferredOrder = array_flip(self::concernOrder);

        collect(class_uses_recursive(static::class))
            ->sortBy(fn (string $trait) => $preferredOrder[$trait] ?? INF)
            ->each(function (string $trait) {
                if (method_exists($trait, $method = 'setUp'.class_basename($trait))) {
                    $this->{$method}();
                }

                if (method_exists($trait, $method = 'tearDown'.class_basename($trait))) {
                    $this->beforeApplicationDestroyed(fn () => $this->{$method}());
                }
            });
    }
}
