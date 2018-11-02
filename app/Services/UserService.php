<?php
namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    public function __construct(UserRepository $userRepo)
    {
        $this->uRepo = $userRepo;
    }

    public function getUserPager(string $q = null)
    {
        return $this->uRepo
            ->getPager(['q' => $q], 20, ['users.id', 'desc']);
    }
    public function createUser($request)
    {
        return $this->uRepo->save($request);
    }

    public function getUserById(int $userId)
    {
        return $this->uRepo->getOneByPk($userId);
    }

    public function updateUser($request)
    {
        return $this->uRepo->update($request);
    }

    public function destroyUser(int $userId)
    {
        return $this->uRepo->destroy($userId);
    }
}
