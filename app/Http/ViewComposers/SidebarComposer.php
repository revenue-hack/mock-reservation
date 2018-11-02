<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class SidebarComposer
{

    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        if (!empty(\Auth::user())) {
            $service = \App::make('\App\Services\UserService');
            $user = \Session::has('user'. \Auth::user()->id) ?
                \Session::get('user'. \Auth::user()->id) :
                $service->getUserById(\Auth::user()->id);
        } else {
            $user = null;
        }
        $view->with('user', $user);
    }
}
