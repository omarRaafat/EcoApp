<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\GuestCustomer;

class ClientOrGuestAuth
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
        if(!auth('api_client')->check()) {
            $token = GuestCustomer::where('token' , $request->header('X-Guest-Token'))->first();
            if(!$token){
                return response()->json([
                    "success" => false,
                    "status" => 406,
                    "message" => "Guest Token Is Not Found"
                ]);
            }
           
        }
        

        return $next($request);
    }
}
