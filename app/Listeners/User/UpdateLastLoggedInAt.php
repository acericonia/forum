<?php

namespace Forum\Listeners\User;

use Illuminate\Auth\Events\Login;

class UpdateLastLoggedInAt
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
     * @param Illuminate\Auth\Events\Login $event
     *
     * @return void
     */
    public function handle(Login $event)
    {
        $event->user->last_login_at = \Carbon\Carbon::now();
        $event->user->save();
    }
}