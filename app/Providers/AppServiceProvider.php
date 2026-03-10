<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use App\Domains\Products\Repositories\EloquentProductRepository;
use App\Domains\Orders\Repositories\Contracts\OrderRepositoryInterface;
use App\Domains\Orders\Repositories\EloquentOrderRepository;
use App\Domains\Users\Repositories\Contracts\UsersRepositoryInterface;
use App\Domains\Users\Repositories\EloquentUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            EloquentProductRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            EloquentOrderRepository::class
        );

        $this->app->bind(
            UsersRepositoryInterface::class,
            EloquentUserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
