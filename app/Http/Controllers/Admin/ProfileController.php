<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

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
            // ClientAuth::class,
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

    public function profiles($clientId)
    {
        try{
            $client = $this->clientService->client($clientId);
            if($client) {
                $profiles = $this->profileService->clientProfiles($clientId);
                return Utilities::okay(ProfileResource::collection($profiles)); 
            }else{
                return Utilities::error402('Client not found');
            }
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function profile($id)
    {
        try{
            if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter ID");
            $profile = $this->profileService->profile($id);
            if(!$profile) return Utilities::error402('Profile not found');
            return Utilities::okay(new ProfileResource($profile));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }
}
