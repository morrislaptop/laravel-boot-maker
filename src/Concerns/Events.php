<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Providers\EventServiceProvider;

trait Events
{
    use Facades;
    use Cache;
    use Application;
    use Filesystem;

    protected function bootEvents() {
        $provider = new EventServiceProvider($this->app);

        $this->app->register($provider);

        $provider->callBootingCallbacks();
    }
}
