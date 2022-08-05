<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Foundation\Testing\DatabaseTransactions as TestingDatabaseTransactions;

trait DatabaseTransactions
{
    use TestingDatabaseTransactions;

    protected function setUpDatabaseTransactions()
    {
        $this->beginDatabaseTransaction();
    }
}
