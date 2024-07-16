<?php

namespace App\Http\Middleware;

use App\Enums\CustomHeaders;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /* Set new lang with the use of session */
        //  $lang = auth('api')->user() ?
        //      auth('api')->user()->lang
        //         : 'ar';


        // App::setLocale($lang);
        /* Set new lang with the use of session */

        if($request->header(CustomHeaders::LANG) != null){
            App::setLocale($request->header(CustomHeaders::LANG));
        } else {
            App::setLocale('ar');
        }
        $lang = App::getLocale();
        if ($request->user("api") && $request->user("api")->lang != $lang) $request->user("api")->update(['lang' => $lang]);

        return $next($request);
    }
}
//cmd
