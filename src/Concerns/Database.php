<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Database\DatabaseServiceProvider;

trait Database
{
    use Config;

    protected function setUpDatabase()
    {
        // Other concerns set this up again.
        if ($this->app->providerIsLoaded(DatabaseServiceProvider::class)) {
            return;
        }

        $database = new DatabaseServiceProvider($this->app);
        $this->app->register($database);

        // Before boot, which resolves the manager and so captures `db.factory`.
        $providers = array_map($this->app->register(...), $this->databaseProviders());

        $database->boot();
        array_map($this->bootProvider(...), $providers);
    }
}
