<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations as BaseDatabaseMigrations;
use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;

trait DatabaseMigrations
{
    protected function setUpDatabaseMigrations()
    {
        // $this->refreshDatabase() calls $this->artisan() which boots the whole framework
        throw new FullBootRequired('RefreshDatabase requires booting the whole framework.');
    }
}
