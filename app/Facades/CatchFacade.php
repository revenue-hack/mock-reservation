<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CatchFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'catch_utility';
    }
}
