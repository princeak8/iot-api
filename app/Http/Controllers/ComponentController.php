<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateComponent;
use App\Http\Requests\UpdateComponent;
use Illuminate\Http\Request;

use App\Http\Resources\ComponentResource;

use App\Services\ComponentService;
use App\Services\ModuleService;
use App\Utilities;

class ComponentController extends Controller
{
    private $componentService;
    private $moduleService;

    public function __construct()
    {
        $this->componentService = new ComponentService;
        $this->moduleService = new ModuleService;
    }

    public function create(CreateComponent $request)
    {
        try{
            $data = $request->all();
            $component = $this->componentService->create($data);
            return Utilities::okay(new ComponentResource($component));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function update(UpdateComponent $request)
    {
        try{
            $data = $request->all();
            $component = $this->componentService->component($data['id']);
            if($component) {
                $component = $this->componentService->update($component, $data);
                return Utilities::okay(new ComponentResource($component));
            }else{
                return Utilities::error402('component not found');
            }
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function components($moduleId)
    {
        try{
            $module = $this->moduleService->module($moduleId);
            if($module) {
                $components = $this->componentService->components($moduleId);
                return Utilities::okay(ComponentResource::collection($components));
            }else{
                return Utilities::error402('module does not exist');
            }
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function component($id)
    {
        try{
            $component = $this->componentService->component($id);
            if($component) {
                return Utilities::okay(new ComponentResource($component));
            }else{
                return Utilities::error402('component not found');
            }
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }
}
