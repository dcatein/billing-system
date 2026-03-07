<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Products\Controllers\ApiProductController;
use App\Http\Middleware\ResolveTenant;

    Route::middleware(ResolveTenant::class)
        ->prefix('products')
        ->group(function () {
            Route::get('/', [ApiProductController::class, 'index']);
            Route::post('/', [ApiProductController::class, 'store'])->name('api.products.store');
            Route::put('{product}', [ApiProductController::class, 'update']);
            Route::delete('{product}', [ApiProductController::class, 'destroy']);
    });


    Route::get('/test', function(){return 'asd';});