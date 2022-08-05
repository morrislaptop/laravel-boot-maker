<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations as BaseDatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions as TestingDatabaseTransactions;
use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;

trait DatabaseTransactions
{
    use TestingDatabaseTransactions;

    protected function setUpDatabaseTransactions()
    {
        $this->beginDatabaseTransaction();
    }
}
