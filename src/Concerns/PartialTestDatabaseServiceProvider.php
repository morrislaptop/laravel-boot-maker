<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Support\ServiceProvider;

class PartialTestDatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('db.factory', fn ($app) => new class($app) extends ConnectionFactory {});
    }
}
