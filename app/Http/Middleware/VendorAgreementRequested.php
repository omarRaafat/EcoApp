<?php

namespace App\Http\Middleware;

use App\Enums\UserTypes;
use App\Models\Vendor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class VendorAgreementRequested
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
        $vendorUser = auth()->user();
        return match ($vendorUser?->type) {
            UserTypes::VENDOR => $this->handleVendor($request, $next, $vendorUser->vendor),
            UserTypes::SUBVENDOR => $this->handleSubVendor($request, $next, $vendorUser->vendor),
            default => $next($request)
        };
    }

    private function handleVendor(Request $request, Closure $next, Vendor $vendor) {
        if (Route::currentRouteName() == "vendor.index") return $next($request);
        if (Route::currentRouteName() == "vendor.agreements.approve") return $next($request);
        if ($vendor->agreements()->pending()->exists()) {
            return redirect(route("vendor.index"));
        }
        return $next($request);
    }

    private function handleSubVendor(Request $request, Closure $next, Vendor $vendor) {
        if ($vendor->agreements()->pending()->exists()) {
            auth()->logout();
            session()->flash('inactive',__("vendors.agreement-required"));
            return redirect()->route("vendor.login");
        }
        return $next($request);
    }
}
