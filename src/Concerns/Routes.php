<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Providers\RouteServiceProvider as AppProvidersRouteServiceProvider;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as FrameworkRouteServiceProvider;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\RoutingServiceProvider;
use Illuminate\Support\ServiceProvider;
use Morrislaptop\LaravelBootMaker\PartialHttpKernel;

trait Routes
{
    // Views: the response factory needs it, even for `response()->json()`.
    use Config, Events, Facades, SetRequestForConsole, Views;

    protected function setUpRoutes()
    {
        $this->setUpSetRequestForConsole();

        $this->app->register(new RoutingServiceProvider($this->app));

        $this->registerAdditionalProviders();

        // Middleware expects a full boot.
        $this->app->instance('middleware.disable', true);
        $this->app->singleton(HttpKernel::class, PartialHttpKernel::class);

        // What `SubstituteBindings` does. It needs no full boot.
        $this->app['events']->listen(function (RouteMatched $event) {
            $this->app['router']->substituteBindings($event->route);
            $this->app['router']->substituteImplicitBindings($event->route);
        });

        // Not `$this->app->boot()`: that also runs every `bootstrap/app.php` callback.
        $this->bootProvider($this->app->register($this->routeServiceProvider(), force: true));

        // `route()` needs these. Laravel refreshes them only on a full boot.
        $routes = $this->app['router']->getRoutes();
        $routes->refreshNameLookups();
        $routes->refreshActionLookups();
    }

    /** Laravel 11 and later have no application provider, so fall back to the framework's. */
    protected function routeServiceProvider(): ServiceProvider
    {
        $provider = class_exists(AppProvidersRouteServiceProvider::class)
            ? AppProvidersRouteServiceProvider::class
            : FrameworkRouteServiceProvider::class;

        return new $provider($this->app);
    }
}
