<?php

namespace App;

use App\Enums\Permission;
use App\Enums\Role;

class EnumClass
{

    public static function permissions()
    {
        return [
            Permission::VIEWING->value,
            Permission::OPERATION->value
        ];
    }

    public static function roles()
    {
        return [
            Role::SUPER_ADMIN->value,
            Role::ADMIN->value,
            Role::USER->value
        ];
    }
    
}