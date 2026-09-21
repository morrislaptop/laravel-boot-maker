<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Testing\DatabaseTransactions as TestingDatabaseTransactions;

trait DatabaseTransactions
{
    use Database, TestingDatabaseTransactions;

    protected function setUpDatabaseTransactions()
    {
        $this->setUpDatabase();

        $this->beginDatabaseTransaction();
    }
}
