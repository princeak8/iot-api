<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public function roleByName($name)
    {
        return Role::where("name", $name)->first();
    }
}