<?php

use App\Domains\Orders\Controllers\ViewOrderController;
use App\Domains\Products\Controllers\ViewProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\ResolveTenant;
use Illuminate\Support\Facades\Route;

Route::middleware('verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware(['auth', ResolveTenant::class])->group(function () {

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard')
        ->middleware('permission:dashboard');

    Route::middleware(['role:manager', 'role:admin'])->group(function () {
        Route::resource(name: 'products', controller: ViewProductController::class);
        Route::resource(name: 'orders', controller: ViewOrderController::class)->except('show');
        Route::put('orders/{id}/pay', [ViewOrderController::class, 'pay'])->name('orders.pay');
        Route::put('orders/{id}/cancel', [ViewOrderController::class, 'cancel'])->name('orders.cancel');
        Route::get('/orders/export', [ViewOrderController::class, 'export'])->name('orders.export');
    });

    Route::middleware('role:seller')->group(function () {
        Route::get('/orders/seller', [ViewOrderController::class, 'seller'])->name('orders.seller');
    });

});



require __DIR__ . '/auth.php';
