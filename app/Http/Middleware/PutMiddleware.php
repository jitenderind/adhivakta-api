<?php
namespace App\Http\Middleware;

use Closure;

class PutMiddleware
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
    if ($request->method() == 'POST' OR $request->method() == 'GET') {
            return $next($request);
        }

        if (preg_match('/multipart\/form-data/', $request->headers->get('Content-Type')) or
            preg_match('/multipart\/form-data/', $request->headers->get('content-type'))
        ) {
            $params = array();
            new ParseInputStream($params);
            $request->request->add($params);

        }
        return $next($request);
    }
}

?>