<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\CreateComponent;
use App\Http\Requests\UpdateComponent;
use Illuminate\Http\Request;

use App\Http\Resources\ComponentResource;

use App\Services\ComponentService;
use App\Services\SubModuleService;
use App\Utilities;

class ComponentController extends Controller
{
    private $componentService;
    private $subModuleService;

    public function __construct()
    {
        $this->componentService = new ComponentService;
        $this->subModuleService = new SubModuleService;
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

    public function components($subModuleId)
    {
        try{
            $subModule = $this->subModuleService->subModule($subModuleId);
            if($subModule) {
                $components = $this->componentService->components($subModuleId);
                return Utilities::okay(ComponentResource::collection($components));
            }else{
                return Utilities::error402('subModule does not exist');
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
