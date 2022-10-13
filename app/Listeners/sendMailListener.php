<?php

namespace App\Listeners;

use App\Events\sendMailEvent;
use App\Mail\mailNotify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class sendMailListener
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
     * @param  \App\Events\sendMailEvent  $event
     * @return void
     */
    public function handle(sendMailEvent $event)
    {
        Mail::to($event->otp['email'])->send(new mailNotify($event->otp));
    }
}
