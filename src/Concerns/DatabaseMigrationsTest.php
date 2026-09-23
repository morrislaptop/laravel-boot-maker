<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class DatabaseMigrationsTest extends PartialTestCase
{
    use DatabaseMigrations;

    public function test_it_migrates_and_writes_rows()
    {
        User::create(['name' => 'Bob', 'email' => 'bob@example.com', 'password' => 'secret']);

        $this->assertSame(1, User::query()->count());
    }
}
