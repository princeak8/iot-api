<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\CreateModuleType;
use App\Http\Resources\ModuleResource;
use App\Http\Resources\ModuleTypeResource;

use App\Services\ModuleTypeService;

use App\Utilities;

class ModuleTypeController extends Controller
{
    private $moduleTypeService;

    public function __construct()
    {
        $this->moduleTypeService = new ModuleTypeService;
    }

    public function save(CreateModuleType $request)
    {
        try{
            $data = $request->validated();
            $moduleType = $this->moduleTypeService->create($data);
            return Utilities::okay(new ModuleTypeResource($moduleType));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function moduleTypes()
    {
        try{
            $moduleTypes = $this->moduleTypeService->types();
            return Utilities::okay(ModuleTypeResource::collection($moduleTypes));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }
}
