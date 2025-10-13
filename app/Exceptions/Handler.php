<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        ValidationException::class,
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
            if ($this->shouldReport($e)) {
                // Log critical errors with context
                if ($e instanceof \Error || $e->getCode() >= 500) {
                    \Log::error('Application Error', [
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                        'url' => request()->fullUrl(),
                        'user_id' => auth()->id(),
                        'ip' => request()->ip(),
                    ]);
                }
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // Handle 404 errors gracefully
        if ($e instanceof NotFoundHttpException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Resource not found',
                    'error' => 'not_found'
                ], 404);
            }

            return response()->view('errors.404', [], 404);
        }

        // Handle 403 Forbidden errors
        if ($e instanceof HttpException && $e->getStatusCode() === 403) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage() ?: 'Access denied',
                    'error' => 'forbidden'
                ], 403);
            }

            return response()->view('errors.403', [
                'message' => $e->getMessage()
            ], 403);
        }

        // Handle authentication errors
        if ($e instanceof AuthenticationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated',
                    'error' => 'unauthenticated'
                ], 401);
            }

            return redirect()->guest(route('login'));
        }

        // Handle validation errors
        if ($e instanceof ValidationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                    'error' => 'validation_failed'
                ], 422);
            }
        }

        // Handle database connection errors
        if ($e instanceof \PDOException || $e instanceof \Illuminate\Database\QueryException) {
            \Log::critical('Database Error', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Database connection error. Please try again later.',
                    'error' => 'database_error'
                ], 500);
            }

            if (config('app.debug')) {
                return parent::render($request, $e);
            }

            return response()->view('errors.500', [
                'message' => 'We\'re experiencing technical difficulties. Please try again later.'
            ], 500);
        }

        // Default error handling
        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into a response.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}

