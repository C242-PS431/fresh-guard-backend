<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function(AuthenticationException $e, Request $request){
            if(str($request->userAgent())->contains(['Mozilla', 'Chrome', 'Edge', 'Firefox'], true)){
                return response()->redirectTo('/');
            }

            return response()->json([
                // 'status'=> 'failed',
                'message' => 'unauthenticated',
                // 'data' => null
            ], 401);
        });
    })->create();
