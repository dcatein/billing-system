<?php

use App\Domains\Products\Controllers\ViewProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\ResolveTenant;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', action: function () {
//     return view('dashboard.index');
// })->middleware(['auth', 'verified'])
// ->name('dashboard');

Route::middleware('verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Route::resource(name: 'products', ViewProductController::class);

});

Route::middleware(['auth', ResolveTenant::class])->group(function () {

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');
    Route::resource(name: 'products', controller: ViewProductController::class);
});



require __DIR__ . '/auth.php';
