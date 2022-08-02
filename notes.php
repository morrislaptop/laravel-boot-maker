<?php

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

public function createApplication()
{
    $app = require __DIR__.'/../bootstrap/app.php';

    $app->make(Kernel::class)->bootstrap();

    return $app;
}

protected function setUpTraits()
{
    $uses = array_flip(class_uses_recursive(static::class));

    if (isset($uses[RefreshDatabase::class])) {
        $this->refreshDatabase();
    }

    if (isset($uses[DatabaseMigrations::class])) {
        $this->runDatabaseMigrations();
    }

    if (isset($uses[DatabaseTransactions::class])) {
        $this->beginDatabaseTransaction();
    }

    if (isset($uses[WithoutMiddleware::class])) {
        $this->disableMiddlewareForAllTests();
    }

    if (isset($uses[WithoutEvents::class])) {
        $this->disableEventsForAllTests();
    }

    if (isset($uses[WithFaker::class])) {
        $this->setUpFaker();
    }

    foreach ($uses as $trait) {
        if (method_exists($this, $method = 'setUp'.class_basename($trait))) {
            $this->{$method}();
        }

        if (method_exists($this, $method = 'tearDown'.class_basename($trait))) {
            $this->beforeApplicationDestroyed(fn () => $this->{$method}());
        }
    }

    return $uses;
}
