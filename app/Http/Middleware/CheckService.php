<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $service)
    {
        $user = Auth::user();

        // Check if the user is authenticated and has the vendor relation loaded
        if ($user && $user->vendor) {
            // Check if the vendor has the required service in their services array
            if (in_array($service, $user->vendor->services ?? [])) {
                return $next($request);
            }
        }

        // If the user does not have the required service, redirect to a specific route to avoid loop
        return redirect()->route('vendor.index')->with('error', 'ليس لديك إذن للوصول إلى هذه الصفحة');
    }
}
