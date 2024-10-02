<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Enums\Role;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( Auth::check() && Auth::user()->role && Auth::user()->role->name == Role::SUPER_ADMIN->value) 
        {
            return $next($request);
        }
        return response()->json(["message" => "unauthorized"], 401);
    }
}
