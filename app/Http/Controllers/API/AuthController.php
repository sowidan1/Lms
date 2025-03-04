<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Services\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        return $this->authService->register($validated);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        return $this->authService->login($credentials);

    }

    public function logout()
    {
        return $this->authService->logout();

    }
}
