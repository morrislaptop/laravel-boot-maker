<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\Facades\Log;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class LoggingTest extends PartialTestCase
{
    use Logging;

    public function test_it_can_test_logs()
    {
        $this->assertNull(Log::info('Does this work?'));
    }
}
