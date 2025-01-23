<?php

namespace App\Exceptions;

use BadMethodCallException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Throwable;

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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Add API exception
     */
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson() || $request->is("api*")) {
            return $this->handleApiException($request, $exception);
        } else {
            $retval = parent::render($request, $exception);
        }

        return $retval;
    }

    /**
     * Handler API exception
     */
    private function handleApiException(Request $request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorize',
                'status' => 401,
            ], 401);
        }

        if ($exception instanceof ValidationException) {
            return response()->json([
                'error' => true,
                'message' => 'Validation error',
                'status' => 400,
                'errors' => $exception->errors(),
            ], 400);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'error' => true,
                'message' => 'This Method is not allowed for the requested route',
                'status' => 405,
            ], 405);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => true,
                'message' => 'This Route is not found',
                'status' => 404,
            ], 404);
        }

        if ($exception instanceof BadMethodCallException) {
            return response()->json([
                'error' => true,
                'message' => 'Bad Method Called',
                'status' => 404,
            ], 404);
        }

        if ($exception instanceof ResourceNotFoundException) {
            return response()->json([
                'error' => true,
                'message' => 'This Resource is not found',
                'status' => 404,
            ], 404);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => true,
                'message' => 'This Resource is not found',
                'status' => 404,
            ], 404);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => true,
                'message' => 'This Resource is not found',
                'status' => 404,
            ], 404);
        }

        if ($exception instanceof QueryException) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage(),
                'status' => 500,
            ], 500);
        }

        return response()->json([
            'error' => true,
            'message' => $exception->getMessage(),
            'status' => 500,
        ], 500);
    }
}
