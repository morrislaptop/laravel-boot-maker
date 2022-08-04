<?php
namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use Illuminate\Support\Facades\Cache as CacheFacade;
use Illuminate\Support\Facades\Event;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class CacheTest extends PartialTestCase
{
    use Cache;

    public function test_it_can_test_cache()
    {
        CacheFacade::put('question', 42);
        expect(CacheFacade::get('question'))->toBe(42);
    }
}
