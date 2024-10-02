<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\EnumClass;
use App\Models\Role;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = EnumClass::roles();
        if(count($roles) > 0) {
            foreach($roles as $role) {
                $roleObj = new Role;
                $roleObj->name = $role;
                $roleObj->save();
            }
        }
    }
}
