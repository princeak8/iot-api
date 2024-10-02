<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Admin;

class Admins extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                "name" => "Akachukwu Aneke",
                "email" => "akalodave@gmail.com",
                "password" => "akalo88"
            ]
        ];
        foreach($admins as $admin) {
            $adminObj = new Admin;
            $adminObj->name = $admin['name'];
            $adminObj->email = $admin['email'];
            $adminObj->password = $admin['password'];
            $adminObj->save();
        }
    }
}
