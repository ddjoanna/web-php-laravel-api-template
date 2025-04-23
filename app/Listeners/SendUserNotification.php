<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendUserRegisteredMailJob;

class SendUserNotification implements ShouldQueue
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
        Log::info('send email notification to user: ' . $user->getId());
        SendUserRegisteredMailJob::dispatch($user);
        Log::info('send sms notification to user: ' . $user->getId());
        // xxxJob::dispatch($user);
    }
}
