<?php
namespace App\Services;

use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;

class RoleService
{
    public function __construct(RoleRepository $roleRepo, UserRepository $userRepo)
    {
        $this->rRepo = $roleRepo;
        $this->uRepo = $userRepo;
    }

    public function getForm()
    {
        return $this->rRepo->getFormList('id', 'role_name');
    }

    public function getRolePager(string $q = null)
    {
        return $this->rRepo->getPager(['q' => $q]);
    }

    public function createRole($request)
    {
        return $this->rRepo->save($request);
    }

    public function getRoleById(int $roleId)
    {
        return $this->rRepo->getOneByPk($roleId);
    }

    public function updateRole($request)
    {
        return $this->rRepo->update($request);
    }

    public function destroyRole(int $roleId)
    {
        if ($this->uRepo->existRecord(['role_id' => $roleId])) {
            return false;
        }
        return $this->rRepo->destroy($roleId);
    }
}
