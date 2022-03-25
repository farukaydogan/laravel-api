<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ResultType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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

        $this->renderable(function (Throwable $e) {
            //dd($e);
            if ($e instanceof ModelNotFoundException)
                return (new ApiController)->apiResponse(ResultType::Error, null, str_replace('App\\', '', $e->getModel()) . 'Model Not Found!', JsonResponse::HTTP_NOT_FOUND);
            elseif ($e instanceof NotFoundHttpException)
                return (new ApiController)->apiResponse(ResultType::Error, null, 'No Records Found!', JsonResponse::HTTP_NOT_FOUND);
        });

    }
}
