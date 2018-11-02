<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ReserveController extends Controller
{
    function __construct()
    {
    }

    public function index()
    {
        return view('reservations.index');
    }

    public function create()
    {
        return view('reservations.create');
    }

    public function destroy($id)
    {
        if (!$this->roleS->destroyRole($id)) {
            \Fetch::reportLog("destroy can't", ['id' => $id], "info");
            return back()->with('save_status', "削除できませんでした");
        }
        return redirect('/roles')
            ->with('save_status', "ID:". $id. "を削除しました");
    }

    public function store(RoleRequest $request)
    {
        if (!is_object($this->roleS->createRole($request))) {
            \Fetch::catchError("can't save", (array) $request);
        }
        return redirect('/roles')
            ->with('save_status', "保存が完了しました");
    }

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

    public function edit($id)
    {
        $record = $this->roleS->getRoleById($id);
        return view('roles.edit')
            ->with('record', $record)
            ->with('id', $id);
    }
}
