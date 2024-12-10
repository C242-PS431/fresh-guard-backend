<?php

use App\Http\Middleware\CustomAuth;
use App\Http\Middleware\GuestMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware([GuestMiddleware::class])->group(function () {
    Route::get('/', function () {
        return view('index');
    });
    Route::get('/login', function () {
        return view('auth.login');
    });
});

Route::middleware([CustomAuth::class])->group(function () {
    Route::get('/scan', function () {
        return view('scan.index', ['date' => 'Aku cinta PHP']);
    });
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    });
    Route::get('/po', fn() => "OK");
});

Route::view('/docs/api/v1/auth', 'docs.v1.auth-api');
Route::view('/docs/api/v1/user', 'docs.v1.user-api');
Route::view('/docs/api/v1/scan', 'docs.v1.scan-api');
Route::view('/docs/api/v1/store', 'docs.v1.store-api');