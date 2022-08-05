<?php
namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use App\Jobs\ShipOrder;
use App\Listeners\AskQuestion;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Bus as BusFacade;
use Illuminate\Support\Facades\Cache as CacheFacade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail as MailFacade;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class MailTest extends PartialTestCase
{
    use Mail;

    // this works out of the box, leaving test for proof.
    public function test_it_can_test_mail()
    {
        MailFacade::fake();

        MailFacade::to('taylor@laravel.com')->send(new OrderShipped());

        MailFacade::assertSent(OrderShipped::class);
    }

    public function test_mailable_content()
    {
        $mailable = new OrderShipped();

        $mailable->assertSeeInHtml('Order Shipped');
    }
}
