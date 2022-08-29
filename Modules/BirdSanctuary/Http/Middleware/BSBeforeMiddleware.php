<?php

namespace Modules\BirdSanctuary\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

class BSBeforeMiddleware
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
        try {
            $hasData = $request->session()->get('userId');
            if (!$hasData){
                \Session::flash('alert-danger', 'Session timeout. Please login.');
                return redirect()->to('bs-admin')->send();
            }
        } catch (Exception $e) {
            \Session::flash('alert-danger', 'Something went wrong.');
            return redirect()->to('bs-admin')->send();
        }

        return $next($request);
    }
}
