<?php

namespace App\Http\Middleware;

use App\Enums\UserTypes;
use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminCan
{
    /**
     * Except routes from permissions checking.
     *
     * @var array
     */
    const EXCEPT_ROUTES = [
        'admin.home',
        'admin.coupons.products',
        'admin.vendor-users.roles',
        'admin.products.get_sub_categories',
        'admin.domestic-zones.get_cities',
        'admin.transactions.sub_orders.resend_receive_code',
        "admin.products.reject",
        "admin.transactions.PrintLabel",
        "admin.aramexTrackShipments",
        "admin.order-tax-invoices.print",
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()->getName();

        if(!in_array($routeName, self::EXCEPT_ROUTES)) {
            if($request->user()->isAdminNotPermittedTo($routeName)) {
                Alert::error(trans("admin.unauthorized_title"), trans("admin.unauthorized_body"));
                return redirect(route('admin.home'));
            }
        }

        return $next($request);
    }
}
