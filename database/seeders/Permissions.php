<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\EnumClass;
use App\Models\Permission;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = EnumClass::permissions();
        foreach($permissions as $perm) {
            $permission = new Permission;
            $permission->name = $perm;
            $permission->save();
        }
    }
}
