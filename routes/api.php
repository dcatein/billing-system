<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Products\Controllers\ApiProductController;
use App\Http\Middleware\ResolveTenant;

Route::middleware(ResolveTenant::class)
    ->name('api.')
    ->group(function () {
        Route::apiResource('products', ApiProductController::class);
});


    Route::get('/test', function(){return 'asd';});