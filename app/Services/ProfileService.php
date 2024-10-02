<?php

namespace App\Services;

use App\Models\Profile;

class ProfileService
{
    public function profile($id)
    {
        return Profile::find($id);
    }

    public function profileByUsername($username)
    {
        return Profile::where('username', $username)->first();
    }

    public function clientProfiles($client_id)
    {
        return Profile::where('client_id', $client_id)->get();
    }

    public function create($data)
    {
        $profile = new Profile;
        $profile->name = $data['name'];
        $profile->about = $data['about'];
        $profile->client_id = $data['clientId'];
        $profile->save();
        return $profile;
    }

    public function update($profile, $data)
    {
        if(isset($data['name'])) $profile->name = $data['name'];
        if(isset($data['username'])) $profile->username = $data['username'];
        if(isset($data['password'])) $profile->password = bcrypt($data['password']);
        $profile->update();
        return $profile;
    }
}


?>