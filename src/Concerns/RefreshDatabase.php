<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait RefreshDatabase
{
    protected function setUpRefreshDatabase()
    {
        // $this->refreshDatabase() calls $this->artisan() which boots the whole framework
        throw new FullBootRequired('RefreshDatabase requires booting the whole framework.');
    }
}
