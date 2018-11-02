<?php

namespace App\Http\Middleware;

use Closure;

class AdminFilter
{
    private $adminOnlyControllers = ['ReserveFrame'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::check()) {
            $user = $request->session()->get('user'. \Auth::user()->id);
            // 特定のcontrollerはadmin権限を持つものしか入れない仕様
            if (preg_match("/Controllers\\\\(.+)Controller@(.+)/", \Route::getCurrentRoute()->getActionName(), $matches) && in_array($matches[1], $this->adminOnlyControllers)) {
                if ((int) \Auth::user()->role_id !== 1) {
                    \Fetch::reportLog("admin unauthorized", (array) $user, "info");
                    return redirect("/")
                        ->with('admin_status', "権限がないので入ることができません");
                }
            }
            if (!$user->user_flag == 1) {
                \Fetch::reportLog("admin unauthorized", (array) $user, "info");
                return redirect("/")
                    ->with('admin_status', "権限がないので入ることができません");
            }
            return $next($request);
        } else {
            return redirect("/auth/login");
        }
    }
}
