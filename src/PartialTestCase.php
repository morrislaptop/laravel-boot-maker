<?php

namespace Morrislaptop\LaravelBootMaker;

use App\Providers\EventServiceProvider as AppProvidersEventServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\EventServiceProvider as FrameworkEventServiceProvider;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;

abstract class PartialTestCase extends TestCase
{
    /** `*` is where unlisted concerns go. */
    private const concernOrder = [
        Concerns\Environment::class,
        Concerns\Config::class,
        Concerns\Facades::class,
        Concerns\Events::class,
        '*',
        // These run application code, which can need any other concern.
        Concerns\AdditionalProviders::class,
        Concerns\Console::class,
        Concerns\Routes::class,
    ];

    private bool $additionalProvidersRegistered = false;

    protected function refreshApplication()
    {
        parent::refreshApplication();

        Facade::setFacadeApplication($this->app);

        $this->failOnFacadeBuiltFromGlobalAlias();
    }

    /**
     * An earlier full boot leaves global aliases like `Auth` behind. Class names are case
     * insensitive, so an unbound `auth` would build the facade instead of failing.
     */
    private function failOnFacadeBuiltFromGlobalAlias(): void
    {
        $this->app->resolving(function (mixed $instance) {
            if ($instance instanceof Facade) {
                throw new BindingResolutionException(
                    'Nothing is bound for ['.$instance::class.']. Use the concern that binds it.'
                );
            }
        });
    }

    public function artisan($command, $parameters = [])
    {
        // Only `Console` marks the app bootstrapped. Otherwise the console kernel runs a full boot.
        if (! $this->app->hasBeenBootstrapped()) {
            throw new FullBootRequired('Without the `Console` concern a command runs a full boot. Add `Console`.');
        }

        return parent::artisan($command, $parameters);
    }

    /** Laravel runs `db:seed`, which needs `Console`. */
    public function seed($class = 'Database\\Seeders\\DatabaseSeeder')
    {
        foreach (Arr::wrap($class) as $class) {
            Model::unguarded(fn () => $this->app->make($class)->setContainer($this->app)->__invoke());
        }

        return $this;
    }

    /** Laravel 11 and later have no application provider, so fall back to the framework's. */
    protected function eventServiceProvider(): ServiceProvider
    {
        $provider = class_exists(AppProvidersEventServiceProvider::class)
            ? AppProvidersEventServiceProvider::class
            : FrameworkEventServiceProvider::class;

        return new $provider($this->app);
    }

    /**
     * Registered only by `AdditionalProviders`, `Routes` and `Console`.
     *
     * @return array<int, string|ServiceProvider>
     */
    protected function additionalProviders(): array
    {
        return [];
    }

    /**
     * Registered by `Database` between the database provider's register and boot.
     *
     * @return array<int, string|ServiceProvider>
     */
    protected function databaseProviders(): array
    {
        return [];
    }

    /**
     * Laravel 11 and later register application commands only on a full boot.
     *
     * @return array<int, string>
     */
    protected function consoleCommands(): array
    {
        return [];
    }

    protected function bootProvider(ServiceProvider $provider): void
    {
        $provider->callBootingCallbacks();

        if (method_exists($provider, 'boot')) {
            $this->app->call([$provider, 'boot']);
        }

        $provider->callBootedCallbacks();
    }

    protected function registerAdditionalProviders(): void
    {
        if ($this->additionalProvidersRegistered) {
            return;
        }

        foreach ($this->additionalProviders() as $provider) {
            $this->bootProvider($this->app->register($provider));
        }

        $this->additionalProvidersRegistered = true;
    }

    protected function setUpTraits()
    {
        $uses = class_uses_recursive(static::class);
        $preferredOrder = array_flip(self::concernOrder);

        collect($uses)
            ->sortBy(fn (string $trait) => $preferredOrder[$trait] ?? $preferredOrder['*'])
            ->each($this->setUpConcern(...));

        return $uses;
    }

    private function setUpConcern(string $trait): void
    {
        if (method_exists($trait, $method = 'setUp'.class_basename($trait))) {
            $this->{$method}();
        }

        if (method_exists($trait, $method = 'tearDown'.class_basename($trait))) {
            $this->beforeApplicationDestroyed(fn () => $this->{$method}());
        }
    }
}
