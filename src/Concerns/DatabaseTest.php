<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class DatabaseTest extends PartialTestCase
{
    use Database;

    public function test_it_can_test_database()
    {
        $this->createUsersTable();

        $this->assertNotNull(User::create([
            'email' => 'craig.michael.morris@gmail.com',
            'name' => 'Craig',
        ]));
    }

    public function test_it_can_use_factories()
    {
        $this->createUsersTable();

        $this->assertNotNull(User::factory()->create());
    }

    public function test_it_can_use_seeds()
    {
        $this->createUsersTable();

        $this->seed();

        $this->assertDatabaseCount('users', 11);
    }

    protected function createUsersTable()
    {
        DB::statement('CREATE TABLE users (
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            created_at DATETIME,
            updated_at DATETIME
        );');
    }
}
