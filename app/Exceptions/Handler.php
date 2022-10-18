<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            Log::error($e->getMessage());
        });

        $this->renderable(function (ValidationException $e) {
            $response = config('rc.bad_request');
            $response['error'] = $e->errors();

            return response()->json($response, 400);
        });

        $this->renderable(function (NotFoundHttpException $e) {
            return response()->json(config('rc.not_found'), $e->getStatusCode());
        });

        $this->renderable(function (AuthenticationException $e) {
            return response()->json(config('rc.unauthorized'), 401);
        });

        $this->renderable(function (ThrottleRequestsException $e) {
            return response(config('rc.too_many_requests'), $e->getStatusCode());
        });

        $this->renderable(function (TokenExpiredException $e) {
            return response()->json(config('rc.unauthorized'), 401);
        });

        $this->renderable(function (JWTException $e) {
            return response()->json(config('rc.unauthorized'), 401);
        });
    }
}
