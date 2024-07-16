<?php

namespace App\Exceptions;

use App\Exceptions\Transactions\PlaceOrderBusinessException;
use App\Exceptions\Wallet\NotEnoughBalance;
use App\Exceptions\Transactions\Addresses\AddressIsInternational;


use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Sentry\Client;
use Sentry\State\Scope;
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
        $this->reportable(function (Throwable $e) {
            if (app()->bound('sentry') && app()->isProduction()) {
                /** @var Client $sentry */
                $sentry = app('sentry');
                \Sentry\configureScope(
                    function (Scope $scope) {
                        $scope->setUser(
                            [
                                'id' => auth()->id() ?? auth('api')->id(),
                            ]
                        );

                        $scope->setTags(
                            [
//                                'some_more_data' => organization('type_flag', ''),
                            ]
                        );
                    }
                );

                $sentry->captureException($e);
            }
        });

        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (NotEnoughBalance $e) {
            return response(["message" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        });
        $this->renderable(function (PlaceOrderBusinessException $e) {

            $response = ["success" => false, "status" => $e->getCode() ?? Response::HTTP_NOT_ACCEPTABLE, "message" => $e->getMessage(), 'data' => []];
            if (!empty($messages = $e->getMessages())) {
                $response = array_merge($response, $messages);
            }
            if ($cartResource = $e->getCartResource()) $response['data'] = $cartResource;

            return response($response, $e->getCode() ?? Response::HTTP_NOT_ACCEPTABLE);
        });

        $this->renderable(function (NotFoundHttpException $e) {
            if (request()->expectsJson()) {
                return response(["message" => $e->getMessage()], $e->getCode() == 0 ? 404 : $e->getCode() ?? Response::HTTP_NOT_FOUND);
            }
        });
        $this->renderable(function (\Exception $e) {
            if ($e->getPrevious() instanceof \Illuminate\Session\TokenMismatchException) {
                if(request()->is("admin/*")) {
                    return redirect()->route('admin.login');
                } elseif(request()->is("vendor/*")) {
                    return redirect()->route('vendor.login');
                }
                abort(419);
                exit();
            };
        });

        $this->renderable(function (AddressIsInternational $e) {
            return response(["message" => $e->getMessage()], $e->getCode() ?? Response::HTTP_NOT_ACCEPTABLE);
        });
    }
}
