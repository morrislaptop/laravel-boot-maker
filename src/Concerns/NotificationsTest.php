<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Models\User;
use App\Notifications\OrderDelivered;
use Illuminate\Support\Facades\Notification;
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
