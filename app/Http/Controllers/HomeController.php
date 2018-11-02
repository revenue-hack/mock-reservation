<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\UserService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    private function userAccess(int $id)
    {
        if ((int) \Auth::user()->id !== (int) $id) {
            return false;
        }
        return true;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('homes.index');
    }

    public function update($id, Request $request, UserService $uS)
    {
        if (!$this->userAccess($id)) {
            return redirect('/')
                ->with('message', "アクセスできません");
        }
        $request->id = $id;
        if ($uS->updateUser($request) != 1) {
            \Fetch::reportLog("Can't update", ['id' => $id], "info");
            return redirect('/')
                ->with('message', "アカウント変更できませんでした");
        }
        $request->session()->forget('user'. \Auth::user()->id);
        return redirect('/')
            ->with('message', "アカウント変更できました");
    }

    public function edit($id, UserService $uS)
    {
        if (!$this->userAccess($id)) {
            return redirect('/')
                ->with('message', "アクセスできません");
        }
        $user = $uS->getUserById($id);
        return view('homes.edit')->with('user', $user);
    }

}
