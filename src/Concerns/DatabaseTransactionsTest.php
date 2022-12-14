<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class DatabaseTransactionsTest extends PartialTestCase
{
    use Database, DatabaseTransactions;

    public function test_it_can_test_database_transactions()
    {
        DB::statement('CREATE TABLE users (
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            created_at DATETIME,
            updated_at DATETIME
        );');

        $this->assertNotNull(User::create([
            'email' => 'craig.michael.morris@gmail.com',
            'name' => 'Craig',
        ]));

        $this->beforeApplicationDestroyed(function () {
            $tables = DB::select('SELECT name FROM sqlite_master');
            $this->assertEmpty($tables);
        });
    }
}
