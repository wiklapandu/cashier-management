<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::prefix('/product')
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
    ])
    ->group(function() {
        Route::get('/', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->middleware(['can:read order'])->name('product.read');
    });

Route::prefix('/order')
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'can:read order'
    ])->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('order.overviews');
        Route::get('/create', [\App\Http\Controllers\Admin\OrderController::class, 'create'])->name('order.create');
    });
