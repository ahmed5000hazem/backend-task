<?php

namespace App\Listeners;

use App\Events\SayWelcomeEvent;
use App\Mail\SayWelcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SayWelcomelistener
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
     * @param  object  $event
     * @return void
     */
    public function handle(SayWelcomeEvent $event)
    {
        Mail::to($event->email)->send(new SayWelcomeMail());
    }
}
