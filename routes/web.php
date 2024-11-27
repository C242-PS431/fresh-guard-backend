<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list', function () {
    return json_encode(Storage::disk('gcs')->files());
});

Route::get('/render', function (Request $request) {
    $file = Storage::disk('gcs')->get('discord.png');
    return response($file, 200,  ['Content-Type' => 'image/png']);
});

Route::get('/download', function (Request $request) {
    $file = Storage::disk('gcs')->get('discord.png');
    return response($file, 200,  ['Content-Type' => 'image/png', 'Content-Disposition' => 'attachment; filename=discord.png']);
});


// Route::fallback(function(){
//     return response("NOT FOUND", status: 404);
// });