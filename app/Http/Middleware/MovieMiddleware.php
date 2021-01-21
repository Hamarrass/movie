<?php

namespace App\Http\Middleware;

use Closure;

class MovieMiddleware
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
       /* if($request->header('token') != env('CLIENT_SECRET')){
            //unauthorized 40
            return response()->json('unauthorized',401);
          };*/
          return $next($request);
    }
}
