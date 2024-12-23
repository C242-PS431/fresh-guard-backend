@extends('layout.base')

@section('title')
    Home
    
@endsection

@section('content')
    @include('partials.header')
    <div class="flex flex-col justify-center items-center h-dvh w-full">
        <h1 class="font-mono text-gray-200 text-4xl font-bold">Selamat Datang di FreshGuard</h1>
        <h3 class="text-xl">The most powerfull <span class="text-violet-600">scanner</span> app</h3>
        <div class="flex flex-row gap-2">
            <button class="btn btn-primary mt-4" id="login">Login</button>
            <button class="btn btn-secondary mt-4" id="register">Register</button>
        </div>
    </div>
    <script>
        document.getElementById('login').onclick = function(){
            window.location.href = '/login';
        }
        
        document.getElementById('register').onclick = function(){
            window.location.href = '/register';
        }
    </script>
@endsection