<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\CategoryUseCaseFactory;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CategoryRepository::class, function ($app) {
            return new CategoryRepository();
        });

        $this->app->singleton(CategoryService::class, function ($app) {
            return new CategoryService($app->make(CategoryRepository::class));
        });

        $this->app->singleton(CategoryUseCaseFactory::class, function ($app) {
            return new CategoryUseCaseFactory(
                $app->make(CategoryRepository::class),
                $app->make(CategoryService::class)
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
