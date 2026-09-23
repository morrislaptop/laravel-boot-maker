<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class AdditionalProvidersWithRoutesTest extends PartialTestCase
{
    use AdditionalProviders, Routes;

    public function test_it_boots_additional_providers_once_when_another_concern_registers_them_too()
    {
        $this->assertSame(1, $this->app['partial-test-provider-booted']);
    }

    protected function additionalProviders(): array
    {
        return [PartialTestServiceProvider::class];
    }
}
