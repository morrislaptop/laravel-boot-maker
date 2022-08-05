<?php
namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use Illuminate\Support\Facades\Cache as CacheFacade;
use Illuminate\Support\Facades\Event;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class TranslationTest extends PartialTestCase
{
    use Translation;

    public function test_it_can_test_translations()
    {
        $this->assertEquals('Welcome to our application!', __('messages.welcome'));
    }
}
