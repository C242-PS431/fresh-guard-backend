@extends('layout.base')

@section('title')
    Home
    
@endsection

@section('content')
    <div class="flex flex-col justify-center items-center h-dvh w-full">
        <div class="hero bg-base-200 rounded-lg w-1/2">
            <div class="hero-content flex-col lg:flex-row-reverse w-full">
              <div class="text-center lg:text-left">
                <h1 class="text-4xl font-bold">Fresh Guard Login</h1>
                <p class="py-6">
                  Nggak punya akun? Register dulu bang.
                </p>
              </div>
              <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
                <form class="card-body">
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">Username</span>
                    </label>
                    <input type="text" placeholder="username" class="input input-bordered" required />
                  </div>
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">Password</span>
                    </label>
                    <input type="password" placeholder="password" class="input input-bordered" required />
                    <label class="label">
                      <a href="#" class="label-text-alt link link-hover">Forgot password?</a>
                    </label>
                  </div>
                  <div class="form-control mt-6">
                    <button class="btn btn-primary">Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
    </div>

@endsection