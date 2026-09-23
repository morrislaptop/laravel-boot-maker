<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Testing\RefreshDatabase as TestingRefreshDatabase;

trait RefreshDatabase
{
    use Console, Database, TestingRefreshDatabase;

    protected function setUpRefreshDatabase()
    {
        $this->setUpDatabase();
        $this->setUpConsole();

        $this->refreshDatabase();
    }
}
