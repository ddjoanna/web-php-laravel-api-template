<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\ProductUseCaseFactory;
use App\Repositories\ProductRepository;
use App\Services\ProductService;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ProductRepository::class, function ($app) {
            return new ProductRepository();
        });

        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepository::class));
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
