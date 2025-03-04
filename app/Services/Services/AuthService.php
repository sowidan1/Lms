<?php

namespace App\Services\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register($validated)
    {
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

    public function login($credentials)
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            return apiError(error: 'Invalid credentials', code: 401);
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
            message: 'User logged out successfully',
            code   : 200
        );
    }
}
