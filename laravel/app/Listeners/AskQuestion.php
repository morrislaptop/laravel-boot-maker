<?php

namespace App\Listeners;

use App\Events\QuestionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AskQuestion
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\QuestionCreated  $event
     * @return void
     */
    public function handle(QuestionCreated $event)
    {
        dump('handled');
    }
}
