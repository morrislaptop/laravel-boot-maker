<?php
namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use Illuminate\Support\Facades\Cache as CacheFacade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class ViewsTest extends PartialTestCase
{
    use Views;

    public function test_it_can_test_views()
    {
        $view = $this->view('greeting', ['name' => 'Taylor']);

        $view->assertSee('Hi Taylor');
    }
}
