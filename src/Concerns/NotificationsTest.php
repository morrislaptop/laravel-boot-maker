<?php
namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use App\Jobs\ShipOrder;
use App\Listeners\AskQuestion;
use App\Mail\OrderShipped;
use App\Models\User;
use App\Notifications\OrderDelivered;
use Illuminate\Support\Facades\Bus as BusFacade;
use Illuminate\Support\Facades\Cache as CacheFacade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail as MailFacade;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class NotificationsTest extends PartialTestCase
{
    use Notifications;

    public function test_it_can_test_notifications()
    {
        Notification::fake();
        $user = new User();

        // Perform order shipping...
        Notification::send($user, new OrderDelivered());

        // Assert that no notifications were sent...
        Notification::assertSentTo($user, OrderDelivered::class);

    }
}
