<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClient;
use App\Http\Requests\UpdateClient;
use Illuminate\Http\Request;

use App\Http\Resources\ClientResource;

use App\Utilities;

use App\Services\ClientService;

class ClientController extends Controller
{
    private $clientService;

    public function __construct()
    {
        $this->clientService = new ClientService;
    }

    public function create(CreateClient $request)
    {
        try{
            $data = $request->all();
            $client = $this->clientService->create($data);
            return Utilities::okay(new ClientResource($client));
        }catch(\Exception $e){
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
}
