<?php

namespace App;

use Illuminate\Console\Command;

class ShoutCommand extends Command
{
    protected $signature = 'shout {word}';

    protected $description = 'Shout a word';

    public function handle()
    {
        $this->info(strtoupper($this->argument('word')));

        return self::SUCCESS;
    }
}
