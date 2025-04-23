<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\UserUseCaseFactory;
use App\Repositories\UserRepository;
use App\Services\UserService;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserRepository();
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService($app->make(UserRepository::class));
        });

        $this->app->singleton(UserUseCaseFactory::class, function ($app) {
            return new UserUseCaseFactory(
                $app->make(UserRepository::class),
                $app->make(UserService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
