<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Jobs\ExampleJobB;

class LogUserRegistration implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegisteredEvent $event): void
    {
        $user = $event->user;
        Log::info('log user registration: ' . $user->getId());
        ExampleJobB::dispatch($user);
    }
}
