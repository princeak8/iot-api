<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\ViewerLogin;
use App\Http\Requests\Login;

use App\Http\Resources\ViewerResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ProfileResource;

use App\Services\AuthService;

use App\Utilities;

class AuthController extends Controller
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService;
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Login $request){
        $credentials = $request->only('email', 'password');
        if (! $token = Auth::attempt($credentials)) return Utilities::error402('Wrong email or password');
        
        $user = new ClientResource(Auth::user());
        $factory = Auth::factory();
        return $this->authService->authResponse([
            'user'=>$user, 
            'factory'=>$factory, 
            'token'=>$token
        ]);
    }
     /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function profileLogin(ViewerLogin $request){
        $credentials = $request->only('username', 'password');
        if (! $token = Auth::guard('profile')->attempt($credentials)) return Utilities::error402('Wrong username or password');
        
        $user = new ProfileResource(Auth::guard('profile')->user());
        $factory = Auth::guard('profile')->factory();
        return $this->authService->authResponse([
            'user'=>$user, 
            'factory'=>$factory, 
            'token'=>$token
        ]);
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewerLogin(ViewerLogin $request){
        $credentials = $request->only('username', 'password');
        if (! $token = Auth::guard('viewer')->attempt($credentials)) return Utilities::error402('Wrong username or password');
        
        $user = new ViewerResource(Auth::guard('viewer')->user());
        $factory = Auth::guard('viewer')->factory();
        $message = 'user not authorised to view';
        if($user->viewing_right == 0) $token = null;
        return $this->authService->authResponse([
            'user'=>$user, 
            'factory'=>$factory, 
            'token'=>$token,
            'message'=>$message
        ]);
    }
}
