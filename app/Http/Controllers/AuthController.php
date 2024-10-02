<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\Login;

use App\Http\Resources\UserResource;

use App\Services\AuthService;
use App\Services\UserService;

use App\Enums\Role;

use App\Utilities;

class AuthController extends Controller
{
    private $authService;
    private $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Login $request){
        $credentials = $request->only('username', 'password');

        // Check if the input is an email or username
        if (filter_var($credentials['username'], FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $credentials['username'];
            unset($credentials['username']);
        }
        if (! $token = Auth::attempt($credentials)) return Utilities::error402('Wrong username/email or password');
        $this->userService->registerLogin(Auth::user());

        $user = new UserResource(Auth::user());
        $factory = Auth::factory();
        if(!$user->permission && $user->role->name != Role::SUPER_ADMIN->value) $token = null;
        return $this->authService->authResponse([
            'user'=>$user, 
            'factory'=>$factory, 
            'token'=>$token
        ]);
    }
}
