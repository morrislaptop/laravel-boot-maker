<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;

trait RefreshDatabase
{
    protected function setUpRefreshDatabase()
    {
        // $this->refreshDatabase() calls $this->artisan() which boots the whole framework
        throw new FullBootRequired('RefreshDatabase requires booting the whole framework.');
    }
}
