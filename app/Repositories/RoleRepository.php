<?php
namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends AppRepository
{
    protected function getQuery(array $where, int $id = null)
    {
        $query = Role::select('roles.*');
        if (!empty($where['q'])) {
            $query->search($where['q']);
        }
        if (!is_null($id)) {
            $query->id($id);
        }
        return $query;
    }

    protected function trunsactionCreate($request)
    {
        return Role::create([
            'role_name' => $request->role_name,
            'privilege_type' => $request->privilege_type,
            'user_flag' => $request->user_flag,
        ]);
    }

    protected function trunsactionUpdate($request)
    {
        return Role::where('id', $request->id)
            ->update([
                'role_name' => $request->role_name,
                'privilege_type' => $request->privilege_type,
                'user_flag' => $request->user_flag,
            ]);
    }

    protected function trunsactionDestroy(int $id)
    {
        return Role::destroy($id);
    }
}
