<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class AdditionalProvidersConcernTest extends PartialTestCase
{
    use AdditionalProviders;

    public function test_it_registers_and_boots_additional_providers_without_routes_or_console()
    {
        $this->assertTrue($this->app->bound('partial-test-provider-registered'));
        $this->assertSame(1, $this->app['partial-test-provider-booted']);
    }

    protected function additionalProviders(): array
    {
        return [PartialTestServiceProvider::class];
    }
}
