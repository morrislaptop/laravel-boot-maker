<?php

namespace Morrislaptop\LaravelBootMaker\Commands;

use Illuminate\Console\Command;

class LaravelBootMakerCommand extends Command
{
    public $signature = 'laravel-boot-maker';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
