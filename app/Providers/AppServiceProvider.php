<?php

namespace App\Providers;

use App\Domains\Payments\Repositories\Contracts\PaymentRepositoryInterface;
use App\Domains\Payments\Repositories\EloquentPaymentRepository;
use Illuminate\Support\ServiceProvider;
use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use App\Domains\Products\Repositories\EloquentProductRepository;
use App\Domains\Orders\Repositories\Contracts\OrderRepositoryInterface;
use App\Domains\Orders\Repositories\EloquentOrderRepository;
use App\Domains\Users\Repositories\Contracts\UsersRepositoryInterface;
use App\Domains\Users\Repositories\EloquentUserRepository;
use Illuminate\Pagination\Paginator;

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

        $this->app->bind(
            PaymentRepositoryInterface::class,
            EloquentPaymentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

    }
}
