<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role']
        ]);

        $token = JWTAuth::fromUser($user);

        return apiSuccess(
            data   : ['token' => $token],
            message: 'User registered successfully',
            code   : 201
        );
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = JWTAuth::attempt($credentials)) {
            return apiError(
                error: 'Unauthorized',
                code : 401
            );
        }

        return apiSuccess(
            data   : ['token' => $token],
            message: 'User logged in successfully',
            code   : 200
        );
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return apiSuccess(
            data   : [],
            message: 'User logged out successfully',
            code   : 200
        );
    }
}
