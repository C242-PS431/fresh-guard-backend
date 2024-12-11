<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class CustomAuth
{
    public function handle(Request $request, Closure $next)
    {
        $personalAccessToken = (isset($_COOKIE['token_login'])) ? $personalAccessToken = PersonalAccessToken::findToken($_COOKIE['token_login']) : null;
        if (blank($personalAccessToken)) {
            return redirect('/');
        }

        /** @var User */
        $user = User::find($personalAccessToken->tokenable_id);
        if (blank($user)) {
            return redirect('/');
        }

        Auth::login($user);
        return $next($request);
    }
}
