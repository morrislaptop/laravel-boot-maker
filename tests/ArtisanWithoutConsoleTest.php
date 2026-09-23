<?php

namespace Morrislaptop\LaravelBootMaker\Tests;

use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;

class ArtisanWithoutConsoleTest extends PartialTestCase
{
    public function test_it_refuses_to_run_a_command_without_console()
    {
        $this->expectException(FullBootRequired::class);

        $this->artisan('inspire');
    }
}
