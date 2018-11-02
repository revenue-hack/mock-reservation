<?php

namespace App\Http\Middleware;

use Closure;

class LoginSession
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
        // login済みのuserのsession作成
        if (\Auth::check()) {
            $userId = \Auth::user()->id;
            $service = \App::make('\App\Services\UserService');
            $user = $service->getUserById($userId);
            $request->session()->put('user'. $userId, $user);
        }
        return $next($request);
    }
}
