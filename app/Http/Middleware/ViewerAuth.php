<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ViewerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( Auth::guard('viewer')->check() && Auth::guard('viewer')->user()->viewing_rights == 1) 
        {
            return $next($request);
        }
        return response()->json(["message" => "unauthorized"], 401);
    }
}
