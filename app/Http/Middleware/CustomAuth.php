<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $personalAccessToken = PersonalAccessToken::findToken($request->cookie('token_login'));
        if(blank($personalAccessToken)){
            return response([$personalAccessToken , $request->cookie(), $request->session()->all(), "SSSSSSS", $_REQUEST, $_COOKIE]);
        }

        $user = User::find($personalAccessToken->tokenable_id);
        if(blank($user)){
            return redirect('/login');
        }

        Auth::login($user);
        return $next($request);
    }
}
