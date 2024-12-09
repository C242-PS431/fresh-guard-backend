<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('index');
});
Route::get('/scan', function () {
    return view('scan.index', ['date' => 'Aku cinta PHP']);
});
Route::get('/user/dashboard', function () {
    return view('user.dashboard');
});
Route::get('/login', function () {
    return view('auth.login');
});
// Route::get('/list', function () {
//     return json_encode(Storage::disk('gcs')->files());
// });

// Route::get('/render', function (Request $request) {
//     $file = Storage::disk('gcs')->get('discord.png');
//     return response($file, 200,  ['Content-Type' => 'image/png']);
// });

// Route::get('/download', function (Request $request) {
//     $file = Storage::disk('gcs')->get('discord.png');
//     return response($file, 200,  ['Content-Type' => 'image/png', 'Content-Disposition' => 'attachment; filename=discord.png']);
// });


// Route::fallback(function(){
//     return response("NOT FOUND", status: 404);
// });


Route::view('/docs/api/v1/auth', 'docs.v1.auth-api');
Route::view('/docs/api/v1/user', 'docs.v1.user-api');
Route::view('/docs/api/v1/scan', 'docs.v1.scan-api');
Route::view('/docs/api/v1/store', 'docs.v1.store-api');