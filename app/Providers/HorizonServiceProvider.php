<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // 只有登入且通過 gate 的使用者可以訪問 Horizon
        Horizon::auth(function ($request) {
            // 依照 Gate 判斷是否授權訪問 Horizon
            // $user = $request->user();
            // return $user && Gate::allows('viewHorizon', $user);

            // 依照 cookie 值判斷是否授權訪問 Horizon
            $expectedKey = config('horizon.horizon_cookie_key');
            $expectedValue = config('horizon.horizon_cookie_secret');
            $cookieValue = $request->cookie($expectedKey);

            return $cookieValue === $expectedValue;
        });

        // 隊列異常時自動通知
        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewHorizon', function ($user) {
            return in_array($user->email, [
                // 儀表板存取權限
                // "joanna@joanna.com",
            ]);
        });
    }
}
