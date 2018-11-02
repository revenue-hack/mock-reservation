<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException as AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException as HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exception\HttpResponseException as HttpResponseException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        //HttpException::class,
        ModelNotFoundException::class,
        //ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        // validationはthrough
        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        }
        // 404エラー
        if ($e instanceof HttpException) {
            return response()->view(
                "errors.400",
                ['exception' => $e],
                $e->getStatusCode()
            );
        // 403エラー
        } elseif ($e instanceof AuthorizationException) {
            return response()->view(
                "errors.400",
                ['exception' => $e],
                $e->getStatusCode()
            );
        // 401エラー
        } elseif ($e instanceof AuthenticationException) {
            return response()->view(
                "errors.400",
                ['exception' => $e],
                $e->getStatusCode()
            );
        }

        // Handling Error
        // 本番環境はdebugモードをとおらないようにする
        if (app()->environment() === 'production') {
            \Util::reportLog('Exception::handling Error', [$e]);
            return response()->view("errors.500", ['exception' => $e], 500);
        }
        return parent::render($request, $e);
    }

}
