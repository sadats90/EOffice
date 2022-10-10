<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class verifyMobile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $is_varified_mobile = Auth::user()->mobile_verified_at;
        if(empty($is_varified_mobile))
        {
            return redirect('applicant/verify-mobile');
        }
        return $next($request);
    }
}
