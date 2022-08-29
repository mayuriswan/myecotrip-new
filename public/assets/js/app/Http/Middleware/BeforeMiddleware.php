<?php

namespace App\Http\Middleware;

use Closure;
use App\Events\LoggingEvent;
class BeforeMiddleware
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
        foreach (getallheaders() as $name => $value)
            {
                if ($name == 'Cookie')
                    continue;    
                $json[$name] = $value;
            }

        $req_str = '[' . $request->ip() . '][' . json_encode($json) . '] -> ' . $request->method() . ' ' . $request->path() . json_encode($request->query()) . $request->getContent() . "\n";

        \Event::fire(new LoggingEvent("REQ", $req_str));
        return $next($request);
    }
}