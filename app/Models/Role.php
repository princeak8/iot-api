<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\Role as RoleEnum;

class Role extends Model
{
    use HasFactory;

    public static function SuperAdmin()
    {
        return Role::where("name", RoleEnum::SUPER_ADMIN->value)->first();
    }

    public static function Admin()
    {
        return Role::where("name", RoleEnum::ADMIN->value)->first();
    }

    public static function User()
    {
        return Role::where("name", RoleEnum::USER->value)->first();
    }
}
