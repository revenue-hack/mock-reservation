<?php

namespace App\Http\Middleware;

use Closure;

class AjaxFilter
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
        // ajax通信でない場合
        //*
        if (!\Request::ajax()) {
            \Fetch::reportLog("ajax connection is not", (array) \Request::all(), 'critical');
            return \Response::json(['status' => 404]);
        }
        //*/
        return $next($request);
    }
}
