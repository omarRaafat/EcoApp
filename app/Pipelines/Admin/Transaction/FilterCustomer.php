<?php
    namespace App\Pipelines\Admin\Transaction;

    use Closure;

    class FilterCustomer
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);
            $search = request('customer');
            if (request()->has('customer') && $search != '')
            {
                $data->whereNested(function($sub_where) use ($search){
                    $sub_where
                        ->where('transactions.customer_id','=',$search)
                        ->orWhere('transactions.customer_name','like', '%' . $search . '%');
                });
                return $data;

                return  $data->Where('customer_id ',request('customer'));
            }
            return $data;
        }
    }