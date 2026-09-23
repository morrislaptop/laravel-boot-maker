<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Redis\RedisManager;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class RedisTest extends PartialTestCase
{
    use Redis;

    public function test_it_binds_the_redis_manager()
    {
        $this->assertInstanceOf(RedisManager::class, $this->app['redis']);
    }
}
