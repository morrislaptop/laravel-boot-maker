<?php

namespace Morrislaptop\LaravelBootMaker;

use App\Providers\EventServiceProvider as AppProvidersEventServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Events\EventServiceProvider as FrameworkEventServiceProvider;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

abstract class PartialTestCase extends TestCase
{
    /** `*` marks where the concerns not listed here sort. */
    private const concernOrder = [
        Concerns\Environment::class,
        Concerns\Config::class,
        Concerns\Facades::class,
        Concerns\Events::class,
        '*',
        // These two run application code, so they go after every other concern.
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
     * A full boot anywhere earlier in the process aliases `Auth`, `DB` and the rest as
     * global classes, and that alias outlives the application it came from. PHP matches
     * class names case insensitively, so the container then answers an unbound `auth`
     * by building `Illuminate\Support\Facades\Auth` itself. The test that missed a
     * concern sees `Call to undefined method` instead of the missing binding, and only
     * when something else ran first.
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

    /**
     * The application's own provider is preferred, since that is what maps its
     * listeners. Laravel 11 and later do not ship one, so the framework's is the
     * fallback: it binds the dispatcher and nothing else.
     *
     * Override this on your own base test case when yours lives elsewhere, or to
     * force the framework's when the application's maps listeners whose dependencies
     * only bind under a full boot.
     */
    protected function eventServiceProvider(): ServiceProvider
    {
        $provider = class_exists(AppProvidersEventServiceProvider::class)
            ? AppProvidersEventServiceProvider::class
            : FrameworkEventServiceProvider::class;

        return new $provider($this->app);
    }

    /**
     * Providers no concern covers, which a route, controller or command reaches for.
     * Only `Routes` and `Console` register these: a provider has prerequisites of its
     * own, so a test that runs no application code should not pay for one.
     *
     * @return array<int, string|ServiceProvider>
     */
    protected function additionalProviders(): array
    {
        return [];
    }

    /**
     * Laravel 11 registers an application's commands from a callback only a full boot
     * fires, so a test names the ones it runs. The partial boot builds those and no
     * others, which is the point.
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
