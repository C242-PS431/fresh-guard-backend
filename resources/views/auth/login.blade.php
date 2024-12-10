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
        <form class="card-body" id="login-form">
          <div class="form-control">
            <label class="label">
              <span class="label-text">Username</span>
            </label>
            <input type="text" name="username" placeholder="username" class="input input-bordered" required />
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text">Password</span>
            </label>
            <input type="password" name="password" placeholder="password" class="input input-bordered" required />
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

<script>
  console.log(window.axios);
  document.getElementById('login-form').addEventListener('submit', async function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    const response = await window.axios.post('/api/auth/login', formData, {})
      .then(response => {
        console.log(JSON.stringify(response));
        localStorage.setItem('token', `Bearer ${response.data.data.token}`);
        window.location.href = '/user/dashboard';
      })
      .catch(error => {
        alert(JSON.stringify(error));
      });
  });
</script>
@endsection