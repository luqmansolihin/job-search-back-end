<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

trait ApiResponses
{
    protected function success(array $data = null, int $statusCode = 200): JsonResponse
    {
        $response = config('rc.ok');
        $response['data'] = $data;

        return response()->json($response, $statusCode);
    }

    protected function successWithTOken(string $token, array $data = null, int $statusCode = 200): JsonResponse
    {
        $response = config('rc.ok');

        $responseToken = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];

        $response['data'] = $data ? Arr::prepend($responseToken, $data, 'user') : $responseToken;

        return response()->json($response, $statusCode);
    }

    protected function error(array $rc, int $statusCode = 400): JsonResponse
    {
        return response()->json($rc, $statusCode);
    }
}
