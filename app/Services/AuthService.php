<?php

namespace App\Services;

use function Laravel\Prompts\error;

class AuthService
{
    public function authResponse($data)
    {
        $user = $data['user'] ?? null;
        $factory = $data['factory'] ?? null;
        $token = $data['token'] ?? null;
        $message = $data['message'] ?? '';
        if($user && $factory) {
            if($token) {
                return response()->json([
                    'statusCode' => 200,
                    'data' => [
                        'token' => $token,
                        'token_type' => 'bearer',
                        'token_expires_in' => $factory->getTTL(), 
                        'user' => $user
                    ]
                ], 200);
            }
            return response()->json([
                'statusCode' => 202,
                'message' => $message,
                'data' => [
                    'user' => $user
                ]
            ], 202);
        }
        throw error(' user or auth not set');
    }
}


?>