<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\ScanResultController;
use App\Http\Controllers\ScanResultTrackController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserAuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Hidehalo\Nanoid\Client;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/auth/register', [UserAuthController::class, 'register']);
Route::post('/auth/login', [UserAuthController::class, 'login'])->name('login');
Route::post('/auth/logout', [UserAuthController::class, 'logout'])
    ->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function(){
    Route::post('/v1/scans/freshness', [ScanController::class, 'scanFreshness']);
    Route::put('/v1/scans/{scanResultId}/track', [ScanController::class, 'trackScan']);
    Route::get('/v1/scans', [ScanResultController::class, 'getScanResults']);
});