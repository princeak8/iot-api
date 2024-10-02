<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\CreateModule;
use App\Http\Requests\DeleteModule;
use App\Http\Requests\UpdateModule;
use Illuminate\Http\Request;

use App\Http\Resources\ModuleResource;

use App\Services\ModuleService;
use App\Services\ProfileService;
use App\Utilities;

class ModuleController extends Controller
{
    private $moduleService;
    private $profileService;

    public function __construct()
    {
        $this->moduleService = new ModuleService;
        $this->profileService = new ProfileService;
    }

    public function create(CreateModule $request)
    {
        try{
            $data = $request->validated();
            // $data['profileId'] = Auth::guard('profile')->user()->id;
            $module = $this->moduleService->create($data); 
            return Utilities::okay(new ModuleResource($module));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function update(UpdateModule $request)
    {
        try{
            $data = $request->all();
            $module = $this->moduleService->module($data['id']);
            if($module) {
                $module = $this->moduleService->update($module, $data); 
                return Utilities::okay(new ModuleResource($module));
            }else{
                return Utilities::error402('module not found');
            }
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function modules($profileId)
    {
        try{
            if (!is_numeric($profileId) || !ctype_digit($profileId)) return Utilities::error402("Invalid parameter profile Id");
            $modules = $this->moduleService->profileModules($profileId);
            return Utilities::okay(ModuleResource::collection($modules));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function module($id)
    {
        try{
            $module = $this->moduleService->module($id);
            if($module) {
                return Utilities::okay(new ModuleResource($module));
            }else{
                return Utilities::error402('module not found');
            }
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function delete(DeleteModule $request)
    {
        try{
            $data = $request->validated();
            $module = $this->moduleService->module($data['id']);
            if($module) {
                $this->moduleService->delete($module);
                return Utilities::okay();
            }else{
                return Utilities::error402('module not found');
            }
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }
}
