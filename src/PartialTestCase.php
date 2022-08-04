<?php

namespace Morrislaptop\LaravelBootMaker;

use Illuminate\Foundation\Bootstrap\RegisterFacades;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;
use Tests\CreatesPartialApplication;

abstract class PartialTestCase extends TestCase
{
    private const ExpectedTraitBootOrder = [
        // Bootstrappers
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
        $uses = array_flip(class_uses_recursive(static::class));

        $preferredOrder = array_flip(self::ExpectedTraitBootOrder);

        collect(class_uses_recursive(static::class))
            ->sortBy(fn (string $trait) => $preferredOrder[$trait] ?? INF)
            ->each(function (string $trait) {
                if (method_exists($this, $method = 'setUp'.class_basename($trait))) {
                    $this->{$method}();
                }

                if (method_exists($this, $method = 'tearDown'.class_basename($trait))) {
                    $this->beforeApplicationDestroyed(fn () => $this->{$method}());
                }
            });

        // if (isset($uses[RefreshDatabase::class])) {
        //     $this->refreshDatabase();
        // }

        // if (isset($uses[DatabaseMigrations::class])) {
        //     $this->runDatabaseMigrations();
        // }

        // if (isset($uses[DatabaseTransactions::class])) {
        //     $this->beginDatabaseTransaction();
        // }

        // if (isset($uses[WithoutMiddleware::class])) {
        //     $this->disableMiddlewareForAllTests();
        // }

        // if (isset($uses[WithoutEvents::class])) {
        //     $this->disableEventsForAllTests();
        // }

        // if (isset($uses[WithFaker::class])) {
        //     $this->setUpFaker();
        // }

        return $uses;
    }
}
