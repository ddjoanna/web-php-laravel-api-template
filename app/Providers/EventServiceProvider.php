<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\UserRegisteredEvent::class => [
            \App\Listeners\SendUserNotification::class,
            \App\Listeners\LogUserRegistration::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();

        // 也可以在這裡用 Event::listen() 手動註冊事件 event('user.registered', [$user]);
        // Event::listen('user.registered', function ($user) {
        //     // 自訂邏輯，例如寄送歡迎信
        //     Log::info('User registered: ' . $user->email);
        // });
    }
}
