<?php
namespace App\Pipelines\Admin\Transaction;

use Closure;

class FilterTracking
{
    public function handle($request, Closure $next)
    {
        $data = $next($request);
        $search = request('gateway_tracking_id');
        if (request()->has('gateway_tracking_id') && request('gateway_tracking_id') != '')
        {
            $data->whereHas('orders.orderShip', function($q) use($search){
                $q->where('gateway_tracking_id' , $search);
            });
        }
        return $data;
    }
}
