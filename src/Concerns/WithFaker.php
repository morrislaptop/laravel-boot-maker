<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations as BaseDatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions as TestingDatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker as TestingWithFaker;
use Illuminate\Foundation\Testing\WithoutEvents as TestingWithoutEvents;
use Illuminate\Foundation\Testing\WithoutMiddleware as TestingWithoutMiddleware;
use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;

trait WithFaker
{
    use Config, TestingWithFaker;

    protected function setUpWithFaker()
    {
        $this->setUpFaker();
    }
}
