<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;

trait DatabaseMigrations
{
    protected function setUpDatabaseMigrations()
    {
        // $this->refreshDatabase() calls $this->artisan() which boots the whole framework
        throw new FullBootRequired('RefreshDatabase requires booting the whole framework.');
    }
}
