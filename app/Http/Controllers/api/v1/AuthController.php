<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Traits\ApiResponses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponses;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!$token = auth()->attempt($request->validated())) {
            throw new AuthenticationException;
        }

        $user = auth()->user()->load('roles')->toArray();

        return $this->successWithToken($token, $user);
    }

    public function refresh(): JsonResponse
    {
        $token = auth()->refresh(true, true);

        return $this->successWithToken($token);
    }

    public function logout(): JsonResponse
    {
        auth()->logout(true);

        return $this->success();
    }
}
