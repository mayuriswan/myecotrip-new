<?php

namespace App\Http\Middleware;

use Closure;
use App\Events\LoggingEvent;

class adminBefore
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

        if ($request->session()->get('userId')) {
            return $next($request);
        }else{
            return redirect()->route('adminLogout');
        }
    }
}
