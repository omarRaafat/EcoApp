<?php

namespace App\Http\Middleware\Eportal;

use App\Services\Eportal\Connection;
use Closure;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class IsValidToken
{
    /**
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $message = 'You are not authenticated to this service';
        try {
            if (Route::currentRouteName() == 'paymant-callback') {
                return $next($request);
            }

            if (auth()->guard('api_client')->check()) {
                return $next($request);
            }

        } catch (\Throwable $exception) {
            Log::error("E-Portal Exception", ['message' => $exception->getMessage()]);
        }

        return response([ 'status' => false ,'message' => $message], Response::HTTP_UNAUTHORIZED);
    }
}
