<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\UserAuth;
use App\Http\Middleware\ProfileAuth;

use App\Http\Requests\CreateUser;
use Illuminate\Http\Request;

use App\Http\Resources\UserResource;

use App\Services\UserService;

use App\Utilities;

class UserController extends Controller implements HasMiddleware
{
    private $userService;

    public function __construct()
    {
        // $this->middleware(ViewerAuth::class);
        $this->userService = new UserService;
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            // UserAuth::class,
            ProfileAuth::class,
            // new Middleware('log', only: ['index']),
            // new Middleware('subscribed', except: ['store']),
        ];
    }

    public function create(CreateUser $request)
    {
        try{
            $data = $request->validated();
            $data['profileId'] = Auth::guard('profile')->user()->id;
            $user = $this->userService->create($data);
            return Utilities::okay(new UserResource($user));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }
}
