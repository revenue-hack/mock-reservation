<?php
namespace App\Repositories;

use App\User;
use App\Models\UserTypeRelation;

class UserRepository extends AppRepository
{
    protected function getQuery(array $where, int $id = null)
    {
        $query = User::join('roles', 'roles.id', '=', 'users.role_id');
        if (!empty($where['role_id'])) {
            $query->roleid($where['role_id']);
        }
        if (!empty($where['q'])) {
            $query->search($where['q']);
        }
        if (!is_null($id)) {
            $query->id($id);
        }
        return $query
            ->select('users.*', 'roles.privilege_type', 'roles.user_flag', 'roles.role_name');
    }

    protected function trunsactionCreate($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password),
        ]);
        if (is_object($user)) {
            return UserTypeRelation::create([
                'user_id' => $user->id,
                'type_id' => $request->type_id,
            ]);
        }
        return false;
    }

    protected function trunsactionUpdate($request)
    {
        return User::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::needsRehash($request->password) ?
                bcrypt($request->password) : $request->password,
                'role_id' => $request->role_id ?? \Auth::user()->role_id,
            ]);
    }

    protected function trunsactionDestroy(int $id)
    {
        return User::destroy($id);
    }
}
