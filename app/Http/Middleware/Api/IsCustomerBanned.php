<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class IsCustomerBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) : RedirectResponse|Response|JsonResponse
    {
        if(!auth('api_client')->check()){
            return response()->json(['status'=>false],401);
        }
        
        if(auth('api_client')->user()->is_banned == true) {
            return response()->json([
                "success" => false,
                "status" => 483,
                "message" => trans("customer.banned")
            ]);
        }

        return $next($request);
    }
}
