<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    public function client($id)
    {
        return Client::find($id);
    }

    public function clients()
    {
        return Client::all();
    }

    public function create($data)
    {
        $client = new Client;
        $client->name = $data['name'];
        $client->email = $data['email'];
        if(isset($data['about'])) $client->about = $data['about'];
        $client->password = bcrypt($data['password']);
        $client->save();
        return $client;
    }

    public function update($client, $data)
    {
        if(isset($data['name'])) $client->name = $data['name'];
        if(isset($data['email'])) $client->email = $data['email'];
        if(isset($data['about'])) $client->about = $data['about'];
        $client->update();
        return $client;
    }
}


?>