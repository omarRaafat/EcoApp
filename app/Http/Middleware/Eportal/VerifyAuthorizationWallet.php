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
use Illuminate\Http\JsonResponse;

class VerifyAuthorizationWallet
{
    /**
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth('api_client')->user() && auth('api_client')->user()->authorizationWallet->id != null){
            return $next($request);
        }
        return  new JsonResponse([
            "success" =>false,
            "status" => 301,
            "data" => [],
            "message" => "يرجى الموافقة على التفويض",
        ], 403);
    }
}
