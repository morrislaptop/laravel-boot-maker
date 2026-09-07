<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\ShoutCommand;
use Illuminate\Console\Scheduling\Schedule;
use Morrislaptop\LaravelBootMaker\Exceptions\FullBootRequired;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class ConsoleTest extends PartialTestCase
{
    use Console;

    public function test_it_runs_a_command_the_kernel_loads()
    {
        $this->artisan('greet', ['name' => 'Bob'])
            ->expectsOutput('Hello Bob')
            ->assertSuccessful();
    }

    public function test_it_runs_a_closure_command_from_the_route_file()
    {
        $this->artisan('inspire')->assertSuccessful();
    }

    public function test_it_runs_a_command_the_test_names()
    {
        $this->artisan('shout', ['word' => 'hi'])
            ->expectsOutput('HI')
            ->assertSuccessful();
    }

    public function test_it_refuses_to_read_a_schedule_it_cannot_fill()
    {
        $this->expectException(FullBootRequired::class);

        $this->app->make(Schedule::class);
    }

    public function test_it_never_boots_the_container()
    {
        $this->artisan('inspire')->run();

        $this->assertFalse($this->app->isBooted());
    }

    public function test_it_registers_and_boots_additional_providers()
    {
        $this->assertTrue($this->app['partial-test-provider-booted']);
    }

    protected function additionalProviders(): array
    {
        return [PartialTestServiceProvider::class];
    }

    protected function consoleCommands(): array
    {
        return [ShoutCommand::class];
    }
}
