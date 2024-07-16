<?php
    namespace App\Pipelines\Admin\Transaction;

    use App\Enums\OrderStatus;
    use Closure;

    class FilterStatus
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);
            $status = request()->get('status', null);
            $main_status = request()->get('main_status', null);

            if ($status && $status != '') {
                if ($status == OrderStatus::PAID)
                    return $data->where(
                        fn($q) => $q->where('transactions.status', OrderStatus::REGISTERD)
                            ->orWhere('transactions.status', OrderStatus::PAID)
                    );
                return  $data->where('transactions.status', $status);
            }
            if ($main_status && $main_status != ''&& $main_status == 'completed') {
                return  $data->whereIn('transactions.status', ['completed','canceled','refund']);
            }elseif ($main_status && $main_status != ''&& $main_status == 'none_completed'){
                return  $data->whereNotIn('transactions.status', ['completed','canceled','refund']);
            }
            return $data;
        }
    }
