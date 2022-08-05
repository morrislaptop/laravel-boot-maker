<?php
namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use Illuminate\Support\Facades\Cache as CacheFacade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class HttpClientTest extends PartialTestCase
{
    // this works out of the box, leaving test for proof.
    public function test_it_can_test_http_client()
    {
        Http::fake();

        $response = Http::get('http://example.com');

        dump($response);
    }
}
