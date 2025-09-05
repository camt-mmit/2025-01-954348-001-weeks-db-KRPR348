<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', static function (): RedirectResponse {
    return redirect()->route('products.list');
});

Route::controller(ProductController::class)
    ->prefix('/products')
    ->name('products.')
    ->group(static function (): void {
        Route::get('', 'list')->name('list');
        Route::get('/create', 'showCreateForm')->name('create-form');
        Route::post('/create', 'create')->name('create');
        Route::prefix('/{product}')->group(static function (): void {
            Route::get('', 'view')->name('view');
            Route::get('/update', 'showUpdateForm')->name('update-form');
            Route::post('/update', 'update')->name('update');
            Route::post('/delete', 'delete')->name('delete');
        });
    });

Route::controller(ShopController::class)
    ->prefix('/shops')
    ->name('shops.')
    ->group(static function (): void {
        route::get('', 'list')->name('list');
        route::get('/create', 'showCreateForm')->name('create-form');
        route::post('/create', 'create')->name('create');
        route::prefix('/{product}')->group(static function (): void {
            route::get('', 'view')->name('view');
            route::get('/update', 'showUpdateForm')->name('update-form');
            route::post('/update', 'update')->name('update');
            route::post('/delete', 'delete')->name('delete');
        });
    });
