<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Services\RoleService;
use App\Services\UserTypeService;
use App\Services\UserService;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $redirectPath = '/';
    protected $loginPath = '/auth/login';
    protected $redirectAfterLogout = '/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => ['getLogout']]);
    }

    /**
     * ユーザ登録画面のaction
     * @param void
     * @return view
     *
     */
    public function getRegister(RoleService $roleS, UserTypeService $userTypeS)
    {
        return view('auth.register')
            ->with('roles', $roleS->getForm())
            ->with('user_types', $userTypeS->getForm());
    }

    /**
     * @see Illuminate\Foundation\Auth\postRegister
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(UserService $userS, UserRequest $request)
    {
        if (!is_object($userS->createUser($request))) {
            \Fetch::catchError("user can't saved", (array) $request);
        }
        return redirect($this->redirectPath())->with('save_status', "ユーザを登録しました");
        //*/
    }

    /**
     * @see Illuminate\Foundation\Auth\AuthenticatesUsers\getLogout
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout(Request $request)
    {
        $request->session()->forget('user'. \Auth::user()->id);
        return $this->logout();
    }
}
