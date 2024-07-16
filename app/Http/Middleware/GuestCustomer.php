<?php

namespace App\Http\Middleware;

use App\Enums\CustomHeaders;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\GuestCustomer as GuestCustomerModel;

class GuestCustomer
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
        $token = $request->header(CustomHeaders::GUEST_TOKEN, null);
        if($token && $guestCustomer = GuestCustomerModel::where('token', $token)->first()) {
            $request->merge(['guestCustomer' => $guestCustomer]);
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
