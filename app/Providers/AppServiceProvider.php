<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\ProductUseCaseFactory;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\Services\ApiResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepository::class, function ($app) {
            return new ProductRepository();
        });

        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepository::class));
        });

        $this->app->singleton(ApiResponse::class, function ($app) {
            return new ApiResponse();
        });

        $this->app->singleton(ProductUseCaseFactory::class, function ($app) {
            return new ProductUseCaseFactory(
                $app->make(ProductRepository::class),
                $app->make(ProductService::class)
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
