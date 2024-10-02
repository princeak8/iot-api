<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Resources\ClientResource;

use App\Http\Requests\CreateClient;
use App\Http\Requests\UpdateClient;

use App\Utilities;

use App\Services\ClientService;
use App\Services\UserService; 

// use App\Enums\Role;
use App\Models\Role;

class ClientController extends Controller
{
    private $clientService;
    private $userService;

    public function __construct()
    {
        $this->clientService = new ClientService;
        $this->userService = new UserService;
    }

    public function create(CreateClient $request)
    {
        try{
            $data = $request->validated();
            DB::beginTransaction();
            $client = $this->clientService->create($data);
            $userData = [
                "username" => "user".$client->id,
                "firstname" => "Super User",
                "password" => "123456789",
                "clientId" => $client->id,
                "roleId" => Role::SuperAdmin()->id,
                "createdBy" => Auth::guard("admin")->user()->id
            ];
            $this->userService->create($userData);
            DB::commit();
            return Utilities::okay(new ClientResource($client));
        }catch(\Exception $e){
            DB::rollBack();
            return Utilities::error($e);
        }
    }

    public function update(UpdateClient $request)
    {
        try{
            $data = $request->all();
            $client = $this->clientService->client($data['id']);
            if($client) {
                $client = $this->clientService->update($client, $data);
                return Utilities::okay(new ClientResource($client));
            }else{
                return Utilities::error402('Client not found');
            }
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function clients()
    {
        try{
            $clients = $this->clientService->clients();
            return Utilities::okay(ClientResource::collection($clients)); 
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function client($id)
    {
        try{
            $client = $this->clientService->client($id);
            if(!$client) return Utilities::error402('CLient not found');
            return Utilities::okay(new ClientResource($client));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }
}
