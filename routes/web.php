<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CategoryController;
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
            Route::get('/shops', 'viewShops')->name('view-shops');
            Route::get('/update', 'showUpdateForm')->name('update-form');
            Route::post('/update', 'update')->name('update');
            Route::post('/delete', 'delete')->name('delete');
            Route::prefix('/shops')->group(static function() : void {
                Route::get('', 'viewShops')->name('view-shops');
                Route::get('/add', 'showAddShopsForm')->name('add-shops-form');
                Route::post('/add', 'addShop')->name('add-shop');
                Route::post('/remove','removeShop')->name('remove-shop');
            });
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
            Route::get('/products', 'viewProducts')->name('view-products');
            route::get('/update', 'showUpdateForm')->name('update-form');
            route::post('/update', 'update')->name('update');
            route::post('/delete', 'delete')->name('delete');
            Route::prefix('/products')->group(static function() : void {
                Route::get('', 'viewProducts')->name('view-products');
                Route::get('/add', 'showAddProductsForm')->name('add-products-form');
                Route::post('/add', 'addProduct')->name('add-product');
                Route::post('/remove','removeProduct')->name('remove-product');
            });
        });
    });

Route::controller(CategoryController::class)
    ->prefix('/categories')
    ->name('categories.')
    ->group(static function (): void {
        route::get('', 'list')->name('list');
        route::get('/create', 'showCreateForm')->name('create-form');
        route::post('/create', 'create')->name('create');
        route::prefix('/{product}')->group(static function (): void {
            route::get('', 'view')->name('view');
            Route::get('/products', 'viewProducts')->name('view-products');
            route::get('/update', 'showUpdateForm')->name('update-form');
            route::post('/update', 'update')->name('update');
            route::post('/delete', 'delete')->name('delete');
            Route::prefix('/products')->group(static function() : void {
                Route::get('', 'viewProducts')->name('view-products');
                Route::get('/add', 'showAddProductsForm')->name('add-products-form');
                Route::post('/add', 'addProduct')->name('add-product');
            });

        });
    });
