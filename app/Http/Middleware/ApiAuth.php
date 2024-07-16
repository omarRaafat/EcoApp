<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $sameuser = 1;
        // to validate the same user
        // if($request->ip() == auth('api')->user()->ip || auth('api')->user()->ip == null)
        // {   
        //     $sameuser = 1;
        // }
        if(auth('api')->user() && auth('api')->user()->type == 'customer' && $sameuser){
            return $next($request);
        }
        return  new JsonResponse([
            "success" =>false,
            "status" => 403,
            "data" => [],
            "message" => __('customer.login.unauthorized'),
        ], 403);
    }
}
