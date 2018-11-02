<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    /**
     * construct
     * @param void
     * @return void
     *
     */
    function __construct(RoleService $roleS)
    {
        $this->roleS = $roleS;
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
        $paginateRoles = $this->roleS->getRolePager($q);
        return view('roles.index')
            ->with('roles', $paginateRoles)
            ->with('q', $q);
    }

    /**
     * create
     * @param void
     * @return view
     *
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * destroy
     * @param int|string $id id
     * @return object redirect
     *
     */
    public function destroy($id)
    {
        if (!$this->roleS->destroyRole($id)) {
            \Fetch::reportLog("Can't destroy", ['id' => $id], "info");
            return back()->with('save_status', "削除できませんでした");
        }
        return redirect('/roles')
            ->with('save_status', "ID:". $id. "を削除しました");
    }

    /**
     * store
     * @param object $request request
     * @return view
     *
     */
    public function store(RoleRequest $request)
    {
        if (!is_object($this->roleS->createRole($request))) {
            \Fetch::catchError("can't save", (array) $request);
        }
        return redirect('/roles')
            ->with('save_status', "保存が完了しました");
    }

    /**
     * update
     * @param string $id id
     * @param object $request request
     * @return view
     *
     */
    public function update($id, RoleRequest $request)
    {
        if (empty($id)) {
            \Fetch::catchError("id not found", (array) $request);
        }
        $record = $this->roleS->getRoleById($id);
        $request->id = $record->id;
        if ($this->roleS->updateRole($request) != 1) {
            \Fetch::catchError("non-object after update",
                (array) $request);
        }
        return redirect('/roles')
            ->with('save_status', "更新が完了しました");
    }

    /**
     * edit
     * @param string $id id
     * @return view
     *
     */
    public function edit($id)
    {
        $record = $this->roleS->getRoleById($id);
        return view('roles.edit')
            ->with('record', $record)
            ->with('id', $id);
    }
}
