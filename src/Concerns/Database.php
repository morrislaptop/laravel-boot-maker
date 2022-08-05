<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Database\DatabaseServiceProvider;

trait Database
{
    use Config;

    protected function setUpDatabase()
    {
        $database = new DatabaseServiceProvider($this->app);
        $this->app->register($database);
        $database->boot();
    }
}
