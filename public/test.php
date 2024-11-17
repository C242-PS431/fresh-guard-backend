<?php

require_once __DIR__ . "/../vendor/autoload.php";
use Illuminate\Support\Facades\Mail;


Mail::raw("Hallo bang", function($message){
    $message->to('ujun.muhammadjunaidi@gmail.com')
            ->subject('Laravel Ujun');
});