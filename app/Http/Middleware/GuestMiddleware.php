<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $personalAccessToken = (isset($_COOKIE['token_login'])) ? $personalAccessToken = PersonalAccessToken::findToken($_COOKIE['token_login']) : null;
        if (!blank($personalAccessToken)) {
            return redirect('/');
        }
        return $next($request);
    }
}
