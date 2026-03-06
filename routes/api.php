<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Products\Controllers\ApiProductController as ProductController;
use App\Http\Middleware\ResolveTenant;

    Route::middleware(ResolveTenant::class)
        ->prefix('products')
        ->group(function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::post('/', [ProductController::class, 'store']);
            Route::put('{product}', [ProductController::class, 'update']);
            Route::delete('{product}', [ProductController::class, 'destroy']);
    });


    Route::get('/test', function(){return 'asd';});