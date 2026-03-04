<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use App\Domains\Products\Repositories\EloquentProductRepository;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
