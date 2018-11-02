<?php

namespace App\Http\Middleware;

use Closure;

class UserActionFilter
{
    private $cantActionOfOne = ['create', 'edit', 'update', 'store', 'getRegister', 'postRegister', 'destroy'];
    private $cantActionOfTwo = ['destroy'];
    private $allEnterActionOfControllers = ['Home'];
    private $flag = false;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::check() &&
            preg_match("/Controllers\\\\(.+)Controller@(.+)/", \Route::getCurrentRoute()->getActionName(), $matches)) {
            $privilegeType =
                \Session::get('user'. \Auth::user()->id)->privilege_type;
            // controller単位でアクセスを許可する
            if (in_array($matches[1], $this->allEnterActionOfControllers)) {
                $this->flag = true;
            // 権限レベル1の場合
            } elseif ((int) $privilegeType === 1 &&
                !in_array($matches[2], $this->cantActionOfOne)) {
                $this->flag = true;
            // 権限レベル2の場合
            } elseif ((int) $privilegeType === 2 &&
                !in_array($matches[2], $this->cantActionOfTwo)) {
                $this->flag = true;
            // 権限レベル3の場合
            } elseif ((int) $privilegeType === 3) {
                $this->flag = true;
            }
        // loginしていないuserは無視
        } else {
            $this->flag = true;
        }

        if ($this->flag) {
            return $next($request);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('message', "権限がないので入ることができません");
        }
    }
}
