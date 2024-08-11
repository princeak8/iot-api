<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Middleware\ClientAuth;
use App\Http\Middleware\ProfileAuth;

use App\Http\Requests\CreateProfile;
use App\Http\Requests\UpdateProfile;
use App\Http\Resources\ProfileResource;
use App\Services\ProfileService;
use App\Services\ClientService;

use App\Utilities;

class ProfileController extends Controller implements HasMiddleware
{
    private $profileService;
    private $clientService;

    public function __construct()
    {
        $this->profileService = new ProfileService;
        $this->clientService = new ClientService;
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            ClientAuth::class,
        ];
    }

    public function create(CreateProfile $request)
    {
        try{
            $data = $request->all();
            $profile = $this->profileService->create($data);
            return Utilities::okay(new ProfileResource($profile));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function update(UpdateProfile $request)
    {
        try{
            $data = $request->all();
            $profile = $this->profileService->profile($data['id']);
            if($profile) {
                $profile = $this->profileService->update($profile, $data);
                return Utilities::okay(new ProfileResource($profile));
            }else{
                return Utilities::error402('profile not found');
            }
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function profiles($id)
    {
        try{
            $client = $this->clientService->client($id);
            if($client) {
                $profiles = $this->profileService->clientProfiles($id);
                return Utilities::okay(ProfileResource::collection($profiles)); 
            }else{
                return Utilities::error402('Client not found');
            }
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }
}
