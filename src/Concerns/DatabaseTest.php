<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Support\Facades\DB;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class DatabaseTest extends PartialTestCase
{
    use Database;

    protected function setUp(): void
    {
        set_error_handler(fn () => false);
        set_exception_handler(fn () => false);

        parent::setUp();
    }

    protected function tearDown(): void
    {
        restore_error_handler();
        restore_exception_handler();

        parent::tearDown();
    }

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

        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('users', 11);
    }

    public function test_the_manager_uses_the_factory_from_database_providers()
    {
        $factory = (fn () => $this->factory)->call($this->app['db']);

        $this->assertNotSame(ConnectionFactory::class, $factory::class);
        $this->assertSame($this->app['db.factory'], $factory);
    }

    protected function databaseProviders(): array
    {
        return [PartialTestDatabaseServiceProvider::class];
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
