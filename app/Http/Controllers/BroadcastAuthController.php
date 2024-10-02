<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

class BroadcastAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        
        $channelName = $request->channel_name;
        
        // if (Auth::check()) {
            return Broadcast::auth($request);
        // }
        // dd('what');
        // if (strpos($channelName, 'private-chat.') === 0) {
        //     $receiverId = substr($channelName, strlen('private-chat.'));
            
        //     // Check if the authenticated user can access this chat
        //     if ($request->user()->canChatWith($receiverId)) {
        //         return Broadcast::auth($request);
        //     }
        // }
        
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
