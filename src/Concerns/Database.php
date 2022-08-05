<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;

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
