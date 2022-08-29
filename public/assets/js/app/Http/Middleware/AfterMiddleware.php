<?php

namespace App\Http\Middleware;

use Closure;
use App\Events\LoggingEvent;
class AfterMiddleware
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
        $response = $next($request);
        foreach (getallheaders() as $name => $value)
            {
                if ($name == 'Cookie')
                    continue;    
                $json[$name] = $value;
            }

        $req_str = '[' . $request->ip() . '] <- ' . $response . "\n";

        \Event::fire(new LoggingEvent("RSP", $req_str));
        return $response;
    }
}