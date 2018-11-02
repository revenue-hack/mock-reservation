<?php
namespace App\Repositories;

use App\Models\UserType;

class UserTypeRepository extends AppRepository
{
    protected function getQuery(array $where, int $id = null)
    {
        $query = UserType::select('user_types.*');
        if (!is_null($id)) {
        }
        return $query;
    }
}
