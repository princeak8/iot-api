<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\AdminLogin as Login;

use App\Http\Resources\AdminResource;

use App\Services\AuthService;
use App\Services\AdminService;

use App\Enums\Role;

use App\Utilities;

class AdminAuthController extends Controller
{
    private $authService;
    private $adminService;

    public function __construct(AuthService $authService, AdminService $adminService)
    {
        $this->authService = $authService;
        $this->adminService = $adminService;
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Login $request){
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::guard("admin")->attempt($credentials)) return Utilities::error402('Wrong email or password');
        $this->adminService->registerLogin(Auth::guard("admin")->user());

        $user = new AdminResource(Auth::guard("admin")->user());
        $factory = Auth::factory();
        return $this->authService->authResponse([
            'user'=>$user, 
            'factory'=>$factory, 
            'token'=>$token
        ]);
    }
}
