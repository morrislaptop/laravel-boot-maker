<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class RoutesTest extends PartialTestCase
{
    use Auth, Routes, Validation;

    public function test_it_hits_a_route_defined_in_the_test()
    {
        Route::get('/ping', fn () => 'pong');

        $this->get('/ping')->assertOk()->assertSee('pong');
    }

    public function test_it_hits_a_route_from_the_applications_route_files()
    {
        $this->get('/me')->assertOk()->assertSee('guest');
    }

    public function test_it_resolves_the_authenticated_user_on_the_request()
    {
        $this->actingAs(new User(['name' => 'Bob']));

        $this->get('/me')->assertOk()->assertSee('Bob');
    }

    public function test_it_renders_a_missing_route_as_a_404()
    {
        $this->get('/nope')->assertNotFound();
    }

    public function test_it_renders_validation_errors()
    {
        $this->postJson('/validate', [])->assertStatus(422)->assertJsonValidationErrors('name');
    }

    public function test_it_registers_and_boots_additional_providers()
    {
        $this->assertTrue($this->app['partial-test-provider-booted']);
    }

    public function test_it_resolves_named_routes()
    {
        $this->assertSame('http://localhost/me', route('me'));
    }

    public function test_it_never_boots_the_container()
    {
        $this->assertFalse($this->app->isBooted());
    }

    public function test_it_validates_an_injected_form_request()
    {
        $this->postJson('/things', [])->assertStatus(422)->assertJsonValidationErrors('name');

        $this->postJson('/things', ['name' => 'Bob'])->assertOk()->assertExactJson(['name' => 'Bob']);
    }

    protected function additionalProviders(): array
    {
        return [PartialTestServiceProvider::class];
    }
}
