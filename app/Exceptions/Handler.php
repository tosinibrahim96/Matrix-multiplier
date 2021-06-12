<?php

namespace App\Exceptions;

use App\Http\ApiResponse;
use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
            //
        });
    }
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ErrorException && $request->isJson()) {
            $status_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            return ApiResponse::sendError($status_code, Response::$statusTexts[$status_code],"Sorry, an error occured while processing this request. We will look into it immediately.");
        }

        if ($e instanceof AuthenticationException) {
            $status_code = Response::HTTP_UNAUTHORIZED;
            return ApiResponse::sendError($status_code,  Response::$statusTexts[$status_code], "Access denied. You are not presently authorized to use this system function.");
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            $status_code = Response::HTTP_METHOD_NOT_ALLOWED;
            return ApiResponse::sendError(Response::HTTP_METHOD_NOT_ALLOWED,  Response::$statusTexts[$status_code], $e->getMessage());
        }

        return parent::render($request, $e);
    }
}
