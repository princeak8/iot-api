<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Admin;

class AdminService
{
    public function admin($id)
    {
        return Admin::find($id);
    }

    public function users()
    {
        return User::all();
    }

    public function create($data)
    {
        $user = new User;
        $user->firstname = $data['firstname'];
        if(isset($data['lastname'])) $user->lastname = $data['lastname'];
        $user->username = $data['username'];
        $user->password = bcrypt($data['password']);
        $user->client_id = $data['clientId'];
        $user->role_id = $data['roleId'];
        if(isset($data['permissionId'])) $user->permission_id = $data['permissionId'];
        if(isset($data['createdBy'])) $user->created_by = $data['createdBy'];
        $user->save();
        return $user;
    }

    public function update($admin, $data)
    {
        if(isset($data['name'])) $admin->name = $data['name'];
        if(isset($data['email'])) $admin->email = $data['email'];
        if(isset($data['password'])) $admin->password = bcrypt($data['password']);
        $admin->update();
        return $admin;
    }

    public function registerLogin($admin)
    {
        $this->update($admin, ['lastLogin'=>Carbon::now()]);
    }
}


?>