<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;

class SocketController extends Controller
{
    

    public function send()
    {
        broadcast(new MessageSent("hello"));
    }
}
