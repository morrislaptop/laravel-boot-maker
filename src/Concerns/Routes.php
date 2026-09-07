<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Providers\RouteServiceProvider as AppProvidersRouteServiceProvider;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as FrameworkRouteServiceProvider;
use Illuminate\Routing\RoutingServiceProvider;
use Illuminate\Support\ServiceProvider;
use Morrislaptop\LaravelBootMaker\PartialHttpKernel;

trait Routes
{
    use Config, Events, Facades, SetRequestForConsole, Views;

    protected function setUpRoutes()
    {
        $this->setUpSetRequestForConsole();

        $this->app->register(new RoutingServiceProvider($this->app));

        $this->registerAdditionalProviders();

        // Middleware is written for a fully booted framework, so skip it.
        $this->app->instance('middleware.disable', true);
        $this->app->singleton(HttpKernel::class, PartialHttpKernel::class);

        // Route files load from this provider's booted callbacks. Booting the
        // container instead would replay every `bootstrap/app.php` callback with them.
        $this->bootProvider($this->app->register($this->routeServiceProvider(), force: true));

        // Deferred by the provider to a callback only a full boot runs, and `route()`
        // needs it.
        $routes = $this->app['router']->getRoutes();
        $routes->refreshNameLookups();
        $routes->refreshActionLookups();
    }

    /**
     * Laravel 11 and later route through the framework's provider, which replays the
     * callback `bootstrap/app.php` gave it. Earlier applications ship their own.
     * Override this when yours lives elsewhere.
     */
    protected function routeServiceProvider(): ServiceProvider
    {
        $provider = class_exists(AppProvidersRouteServiceProvider::class)
            ? AppProvidersRouteServiceProvider::class
            : FrameworkRouteServiceProvider::class;

        return new $provider($this->app);
    }
}
