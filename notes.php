<?php

protected function setUp(): void
{
    $this->setUpTraits();

    foreach ($this->afterApplicationCreatedCallbacks as $callback) {
        $callback();
    }

    Model::setEventDispatcher($this->app['events']);

    $this->setUpHasRun = true;
}

        /**
     * Boot the testing helper traits.
     *
     * @return array
     */
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

    /**
     * Bootstrap the application for artisan commands.
     *
     * @return void
     */
    public function bootstrap()
    {
        if (! $this->app->hasBeenBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrappers());
        }

        if (! $this->commandsLoaded) {
            $this->commands();

            $this->commandsLoaded = true;
        }
    }

        protected $bootstrappers = [
            \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
            \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
            \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
            \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
            \Illuminate\Foundation\Bootstrap\SetRequestForConsole::class,
            \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
            \Illuminate\Foundation\Bootstrap\BootProviders::class,
        ];

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
        if (method_exists($this, $method = 'tearDown'.class_basename($trait))) {
            $this->beforeApplicationDestroyed(fn () => $this->{$method}());
        }
    }

    return $uses;
}

// ---------------------

/**
 * Clean up the testing environment before the next test.
 *
 * @return void
 *
 * @throws \Mockery\Exception\InvalidCountException
 */
protected function tearDown(): void
{
    if ($this->app) {
        $this->callBeforeApplicationDestroyedCallbacks();

        ParallelTesting::callTearDownTestCaseCallbacks($this);

        $this->app->flush();

        $this->app = null;
    }

    $this->setUpHasRun = false;

    if (property_exists($this, 'serverVariables')) {
        $this->serverVariables = [];
    }

    if (property_exists($this, 'defaultHeaders')) {
        $this->defaultHeaders = [];
    }

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

    if (class_exists(Carbon::class)) {
        Carbon::setTestNow();
    }

    if (class_exists(CarbonImmutable::class)) {
        CarbonImmutable::setTestNow();
    }

    $this->afterApplicationCreatedCallbacks = [];
    $this->beforeApplicationDestroyedCallbacks = [];

    Artisan::forgetBootstrappers();
    Queue::createPayloadUsing(null);
    HandleExceptions::forgetApp();

    if ($this->callbackException) {
        throw $this->callbackException;
    }
}
