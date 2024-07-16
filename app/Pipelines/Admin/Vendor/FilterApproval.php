<?php
    namespace App\Pipelines\Admin\Vendor;

    use Closure;

    class FilterApproval
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);
            $approval = request('approval');
            if (request()->has('approval') && $approval != '' && in_array($approval,['pending','approved','not_approved']))
            {
                return  $data->Where('approval',$approval);
            }
            return $data;
        }
    }