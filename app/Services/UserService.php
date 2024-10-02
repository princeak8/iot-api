<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;

class UserService
{
    public function user($id)
    {
        return User::find($id);
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
        if(isset($data['email'])) $user->email = $data['email'];
        if(isset($data['permissionId'])) $user->permission_id = $data['permissionId'];
        if(isset($data['createdBy'])) $user->created_by = $data['createdBy'];
        $user->save();
        return $user;
    }

    public function update($user, $data)
    {
        if(isset($data['name'])) $user->name = $data['name'];
        if(isset($data['username'])) $user->username = $data['username'];
        if(isset($data['password'])) $user->password = bcrypt($data['password']);
        if(isset($data['permissionId'])) $user->permission_id = $data['permissionId'];
        if(isset($data['roleId'])) $user->role_id = $data['roleId'];
        $user->update();
        return $user;
    }

    public function registerLogin($user)
    {
        $this->update($user, ['lastLogin'=>Carbon::now()]);
    }
}


?>