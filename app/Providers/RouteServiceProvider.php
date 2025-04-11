<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * 這個路由名稱空間會自動加到所有路由中
     *
     * @var string
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * 這是應用程式的路由設定。您可以在這裡註冊任何應用程式的路由。
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * 註冊 API 路由
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api') // 指定路由前綴為 api
            ->middleware('api') // 使用 api 中介層
            ->namespace($this->namespace) // 使用指定的命名空間
            ->group(base_path('routes/api.php')); // 來自 routes/api.php 的路由
    }

    /**
     * 註冊 Web 路由
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web') // 使用 web 中介層
            ->namespace($this->namespace) // 使用指定的命名空間
            ->group(base_path('routes/web.php')); // 來自 routes/web.php 的路由
    }
}
