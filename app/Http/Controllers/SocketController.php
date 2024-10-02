<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;

use App\Events\PublishData;
use App\Events\Publish;

use App\Services\SubModuleService;
use App\Utilities;

class SocketController extends Controller
{
    
    private $subModuleService;

    public function __construct()
    {
        $this->subModuleService = new SubModuleService;
    }

    public function send(Request $request)
    {
        $data =  $request->all();
        // broadcast(new MessageSent("hello"));
        // if(!isset($data['id']))
        $broadcastData = [
            "status" => $data['status'],
            "mw" => $data['mw'],
            "v" => $data['v'],
            "A" => $data['a']
        ];
        // if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter Id");
        $subModule = $this->subModuleService->subModule($data['id']);
        if(!$subModule) return Utilities::error402("SubModule not found");
        broadcast(new Publish($subModule->topic, json_encode($broadcastData)))->toOthers();
        return Utilities::okay("Data Sent");
    }
}
