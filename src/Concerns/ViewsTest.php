<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

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
