<?php
namespace App\Services;

use App\Repositories\UserTypeRepository;

class UserTypeService
{
    public function __construct(UserTypeRepository $utRepo)
    {
        $this->utRepo = $utRepo;
    }

    public function getForm()
    {
        return $this->utRepo->getFormList('id', 'type_name');
    }
}
