<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Testing\DatabaseMigrations as TestingDatabaseMigrations;

trait DatabaseMigrations
{
    use Console, Database, TestingDatabaseMigrations;

    protected function setUpDatabaseMigrations()
    {
        $this->setUpDatabase();
        $this->setUpConsole();

        $this->runDatabaseMigrations();
    }
}
