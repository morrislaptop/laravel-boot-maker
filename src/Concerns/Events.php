<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Providers\EventServiceProvider;

trait Events
{
    use Facades;
    use Cache; // @todo this loads config as well but not needed for events...
    use Application;
    use Filesystem;

    protected function setUpEvents() {
        $provider = new EventServiceProvider($this->app);

        $this->app->register($provider);

        $provider->callBootingCallbacks();
    }
}
