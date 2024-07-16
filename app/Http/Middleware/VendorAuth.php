<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\UserTypes;
use Illuminate\Http\Request;

class VendorAuth
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
        $user=auth()->user();
        if ( auth()->user() && ( $user->type == UserTypes::VENDOR || $user->type == UserTypes::SUBVENDOR ) ){
            if ( $user->is_banned==0 && $user->vendor->approval == 'approved' && $user->vendor->is_active)
            {
                return $next($request);
            }
            auth()->logout();
        }
        
        session()->flash('inactive',__("vendors.inactive"));
        return redirect()->route("vendor.login");
    }
}
