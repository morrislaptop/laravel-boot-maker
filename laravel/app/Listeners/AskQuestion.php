<?php

namespace App\Listeners;

use App\Events\QuestionCreated;

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
