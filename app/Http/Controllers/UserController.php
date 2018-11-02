<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests;
use App\Services\UserService;
use App\Services\UserTypeService;
use App\Services\RoleService;

class UserController extends Controller
{
    /**
     * construct
     * @param void
     * @return void
     *
     */
    function __construct(UserService $userS)
    {
        $this->userS = $userS;
    }

    /**
     * index
     * @param void
     * @return view
     *
     */
    public function index()
    {
        $q = \Request::has('q') ? \Request::get('q') : null;
        $paginateUsers = $this->userS->getUserPager($q);
        return view('users.index')
            ->with('users', $paginateUsers)
            ->with('q', $q);
    }

    /**
     * destroy
     * @param int|string $id id
     * @return object redirect
     *
     */
    public function destroy($id)
    {
        if (!$this->userS->destroyUser($id)) {
            \Fetch::reportLog("destroy can't", ['id' => $id], "info");
            return back()->with('save_status',
                "このデータは他のデータで使われているため、削除できませんでした");
        }
        return redirect('/users')->with('save_status', "ID:". $id. "を削除しました");
    }

    /**
     * update
     * @param string $id id
     * @param object $request request
     * @return view
     *
     */
    public function update($id, UserRequest $request)
    {
        if (empty($id)) {
            \Fetch::catchError("id not found", (array) $request);
        }
        $record = $this->userS->getUserById($id);
        $request->id = $record->id;
        if ($this->userS->updateUser($request) != 1) {
            \Fetch::catchError("non-object after update",
                (array) $request);
        }
        \Session::forget('user'. $id);
        \Session::put('user'. $id, $this->userS->getUserById($id));
        return redirect('/users')
            ->with('save_status', "更新が完了しました");
    }

    /**
     * edit
     * @param string $id id
     * @return view
     *
     */
    public function edit($id, RoleService $roleS, UserTypeService $typeS)
    {
        return view('users.edit')
            ->with('record', $this->userS->getUserById($id))
            ->with('roles', $roleS->getForm())
            //->with('types', $typeS->getForm())
            ->with('id', $id);
    }
}
