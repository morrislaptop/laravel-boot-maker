<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\Facades\Http;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class HttpClientTest extends PartialTestCase
{
    // this works out of the box, leaving test for proof.
    public function test_it_can_test_http_client()
    {
        Http::fake();

        $response = Http::get('http://example.com');

        $this->assertTrue($response->ok());
    }
}
