<?php

namespace App\Services;

use App\Models\Viewer;

class ViewerService
{
    public function viewer($id)
    {
        return Viewer::find($id);
    }

    public function viewers()
    {
        return Viewer::all();
    }

    public function create($data)
    {
        $viewer = new Viewer;
        $viewer->name = $data['name'];
        $viewer->username = $data['username'];
        $viewer->password = bcrypt($data['password']);
        $viewer->profile_id = $data['profileId'];
        $viewer->save();
        return $viewer;
    }

    public function update($viewer, $data)
    {
        if(isset($data['name'])) $viewer->name = $data['name'];
        if(isset($data['username'])) $viewer->username = $data['username'];
        if(isset($data['password'])) $viewer->password = bcrypt($data['password']);
        if(isset($data['lastLogin'])) $viewer->last_login = $data['lastLogin'];
        if(isset($data['viewingRights'])) $viewer->viewing_rights = $data['viewingRights'];
        $viewer->update();
        return $viewer;
    }
}


?>