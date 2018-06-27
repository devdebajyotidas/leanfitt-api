<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Traits\RestExceptionHandlerTrait;
use App\Traits\RestTrait;

class Handler extends ExceptionHandler
{
    use RestTrait;
    use RestExceptionHandlerTrait;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        return parent::render($request, $exception);

//        if(!$this->isApiCall($request)) {
//            $retval = parent::render($request, $exception);
//        } else {
//            $retval = $this->getJsonResponseForException($request, $exception);
//        }
//
//        return $retval;
    }
}