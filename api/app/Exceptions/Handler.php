<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
    public function register() {
        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'code' => 'validation',
                    'message' => $e->getMessage(),
                    'errors' => $e->errors(),
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if (!$e->getPrevious()) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'code' => 'http_not_found',
                        'message' => 'Not found.',
                        'status' => Response::HTTP_NOT_FOUND,
                    ], Response::HTTP_NOT_FOUND);
                }
                return;
            }

            switch (get_class($e->getPrevious())) {
                case 'Illuminate\Database\Eloquent\ModelNotFoundException':
                    if ($request->is('api/*')) {
                        return response()->json([
                            'code' => 'record_not_found',
                            'message' => preg_replace('/[a-zA-Z]+\\\\/', '', $e->getPrevious()->getMessage()),
                            'status' => 404,
                        ], 404);
                    }
                    break;
                default:
                    if ($request->is('api/*')) {
                        return response()->json([
                            'code' => 'http_not_found',
                            'message' => 'Not found.',
                            'status' => 404,
                        ], 404);
                    }
                    break;
            }
        });
    }
}
