<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class UserAuthController extends Controller
{
    public function createSuccessResponse($user, $token, string $message, $statusCode)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'created_at' => $user->created_at
                ],
                'token' => $token->plainTextToken,
                'token_expires_at' => $token->accessToken->expires_at
            ]
        ], $statusCode);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        /** @var \App\Models\User */
        $user = User::create($credentials);
        $token = $user->createToken($request->input('device_name') ?: $request->header('User-Agent'));
        Auth::login($user);
        $cookie = cookie('token_login', $token->plainTextToken, 100000);
        return $this->createSuccessResponse($user, $token, __('auth.register.success'), 201)
            ->withCookie($cookie);
    }

    public function login(Request $request): JsonResponse
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $deviceName = $request->input('device_name') ?: $request->header('User-Agent');

        /** @var User */
        $user = User::where('username', $username)->first();
        if (is_null($user) || !Hash::check($password, $user->password)) {
            throw new HttpResponseException(response()->json([
                "status" => "fail",
                "data" => null,
                "message" => __('auth.usernamepassword')
            ], 400));
        }
        $token = $user->createToken($deviceName);
        Auth::login($user);
        $cookie = cookie('token_login', $token->plainTextToken, 100000);
        return $this->createSuccessResponse($user, $token, __('auth.login.success'), 200)
            ->withCookie($cookie);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        session()->flush();
        $cookie = cookie('token_login', "kosong", 0);
        return response()->json([
            'status' => 'success',
            'message' => __('auth.logout.success')
        ], 200)
            ->cookie($cookie);
    }
}
