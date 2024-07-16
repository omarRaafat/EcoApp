<?php
    namespace App\Pipelines\Admin\Vendor;

    use Closure;

    class FilterName
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);
            $search = request('name');

            if (request()->has('name') && $search != '')
            {
                //hint : Laravel-translatable don't work inside pipeline filter class this code is to override this problem
                $key = 0;
                foreach (config('app.locales') AS $locale)
                {
                    if($key == 0)
                    {
                        $data->where('name->' . $locale, 'LIKE', "%{$search}%");
                    }
                    else
                    {
                        $data->orWhere('name->' . $locale, 'LIKE', "%{$search}%");
                    }
                    $key++;
                }
            }
            return $data;
        }
    }