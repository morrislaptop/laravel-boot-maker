<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\Facades\Cache as CacheFacade;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class CacheTest extends PartialTestCase
{
    use Cache;

    public function test_it_can_test_cache()
    {
        CacheFacade::put('question', 42);
        $this->assertEquals(42, CacheFacade::get('question'));
    }
}
