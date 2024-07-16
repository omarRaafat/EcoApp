<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
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
        if(auth()->user() &&(auth()->user()->type == 'admin' || auth()->user()->type == 'sub-admin')){
            return $next($request);
        }
        
        session()->put("redirectAfterLogin", parse_url($request->fullUrl(), PHP_URL_PATH));        
        return redirect('admin/login');
    }
}
