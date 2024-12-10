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
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $personalAccessToken = (isset($_COOKIE['token_login'])) ? $personalAccessToken = PersonalAccessToken::findToken($_COOKIE['token_login']) : null;
        if (!blank($personalAccessToken)) {
            return back();
        }
        return $next($request);
    }
}
