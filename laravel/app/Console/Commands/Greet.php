<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Greet extends Command
{
    protected $signature = 'greet {name}';

    protected $description = 'Greet someone';

    public function handle()
    {
        $this->info('Hello '.$this->argument('name'));

        return self::SUCCESS;
    }
}
