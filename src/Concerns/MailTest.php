<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail as MailFacade;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class MailTest extends PartialTestCase
{
    use Mail;

    // this works out of the box, leaving test for proof.
    public function test_it_can_test_mail()
    {
        MailFacade::fake();

        MailFacade::to('taylor@laravel.com')->send(new OrderShipped);

        MailFacade::assertSent(OrderShipped::class);
    }

    public function test_mailable_content()
    {
        $mailable = new OrderShipped;

        $mailable->assertSeeInHtml('Order Shipped');
    }
}
