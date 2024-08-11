<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Middleware\ViewerAuth;
use App\Http\Middleware\ProfileAuth;

use App\Http\Requests\CreateViewer;
use Illuminate\Http\Request;

use App\Http\Resources\ViewerResource;

use App\Services\ViewerService;

use App\Utilities;

class ViewerController extends Controller implements HasMiddleware
{
    private $viewerService;

    public function __construct()
    {
        // $this->middleware(ViewerAuth::class);
        $this->viewerService = new ViewerService;
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            // ViewerAuth::class,
            ProfileAuth::class,
            // new Middleware('log', only: ['index']),
            // new Middleware('subscribed', except: ['store']),
        ];
    }

    public function create(CreateViewer $request)
    {
        try{
            $data = $request->validated();
            $viewer = $this->viewerService->create($data);
            return Utilities::okay(new ViewerResource($viewer));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }
}
