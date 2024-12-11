<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\ScanResultController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreGaleryController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/auth/register', [UserAuthController::class, 'register']);
Route::post('/auth/login', [UserAuthController::class, 'login'])->name('login');
Route::post('/auth/logout', [UserAuthController::class, 'logout'])
    ->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function(){
    Route::get('/v1/profile', [UserController::class, 'getProfile']);
    Route::get('/v1/profile/picture', [UserController::class, 'getPfp']);
    Route::post('/v1/scans/freshness', [ScanController::class, 'scanFreshness']);
    Route::put('/v1/scans/{scanResultId}/track', [ScanController::class, 'trackScan']);
    Route::get('/v1/scans', [ScanResultController::class, 'getScanResults']);
    Route::get('/v1/stores', [StoreController::class, 'getStores']);
    Route::get('/v1/stores/{storeId}', [StoreController::class, 'findStore']);
    Route::post('/v1/stores/{storeId}/favorite', [StoreController::class, 'addFavoriteStore']);
    Route::delete('/v1/stores/{storeId}/favorite', [StoreController::class, 'removeFavoriteStore']);
    Route::get('/v1/stores/{storeId}/galeries', [StoreController::class, 'getStoreGaleries']);
    Route::get('/v1/stores/{storeId}/galeries/{galeryId}', [StoreGaleryController::class, 'getStoreImage']);
    Route::get('/v1/stores/{storeId}/products', [ProductController::class, 'getStoreProducts']);
    Route::get('/v1/stores/{storeId}/products/{productId}/categories', [ProductController::class, 'getStoreProducts']);
    Route::get('/v1/products/categories', [CategoryController::class, 'getListProductCategories']);
    Route::get('/v1/nutritions', [ScanResultController::class, 'getUserNutiritionByDate']);
});