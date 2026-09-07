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
        // The console kernel bootstraps unless the application says it already has.
        // Saying so without running a bootstrapper is what keeps this partial, and it
        // leaves the application's own kernel, and its `commands()`, in place.
        $this->app->bootstrapWith([]);

        // migrate, make:* and the rest.
        $this->app->register(new ConsoleSupportServiceProvider($this->app));

        $kernel = $this->app->make(Kernel::class);

        if ($kernel instanceof FoundationKernel) {
            $kernel->addCommands($this->consoleCommands());
        }

        $this->registerAdditionalProviders();

        // The schedule comes from a callback only a full boot fires, so it always
        // reads as empty. Left alone it would pass a test asserting nothing is there.
        $this->app->bind(Schedule::class, fn () => throw new FullBootRequired(
            'The schedule is defined on a full boot, so a partial one always reads as empty. Test scheduling on the full TestCase.'
        ));
    }
}
