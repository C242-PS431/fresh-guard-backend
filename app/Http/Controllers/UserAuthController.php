<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
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
        return $this->createSuccessResponse($user, $token, 'Registrasi Sukses', 201);
    }

    public function login(Request $request): JsonResponse
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $deviceName = $request->input('device_name') ?: $request->header('User-Agent');

        $user = User::where('username', $username)->first();
        if (is_null($user) || !Hash::check($password, $user->password)) {
            throw new HttpResponseException(response()->json([
                "status" => "fail",
                "data" => null,
                "message" => "Username atau Password salah."
            ], 400));
        }
        $token = $user->createToken($request->input('device_name') ?: $request->header('User-Agent'));

        return $this->createSuccessResponse($user, $token, 'Login Sukses', 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'succes',
            'message' => 'Logout berhasil'
        ], 200);
    }
}
