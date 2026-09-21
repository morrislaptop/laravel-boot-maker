<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Console\Kernel as FoundationKernel;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;

trait Console
{
    use Config, Events, Facades;

    protected function setUpConsole()
    {
        // Otherwise the console kernel runs a full bootstrap.
        $this->app->bootstrapWith([]);

        $this->app->register(new ConsoleSupportServiceProvider($this->app));

        $kernel = $this->app->make(Kernel::class);

        if ($kernel instanceof FoundationKernel) {
            $kernel->addCommands($this->consoleCommands());
        }

        $this->registerAdditionalProviders();

        $this->app->bind(Schedule::class, fn () => throw new FullBootRequired(
            'The schedule is defined on a full boot, so a partial one always reads as empty. Test scheduling on the full TestCase.'
        ));
    }
}
