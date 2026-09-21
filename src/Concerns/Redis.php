<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Redis\RedisServiceProvider;

trait Redis
{
    use Config;

    protected function setUpRedis()
    {
        $redis = new RedisServiceProvider($this->app);
        $this->app->register($redis);
    }
}
