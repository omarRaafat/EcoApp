<?php
    namespace App\Pipelines\Admin\Transaction;

    use Closure;

    class FilterCode
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);

            if (request()->has('transaction_id') && request('transaction_id') != '')
            {
                return  $data->Where('transactions.code',request('transaction_id'));
            }
            return $data;
        }
    }