<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class AdditionalProvidersTest extends PartialTestCase
{
    use Translation;

    /** A provider has prerequisites of its own, and this test reaches no application code. */
    public function test_it_leaves_additional_providers_alone_without_routes_or_console()
    {
        $this->assertFalse($this->app->bound('partial-test-provider-booted'));
    }

    protected function additionalProviders(): array
    {
        return [PartialTestServiceProvider::class];
    }
}
