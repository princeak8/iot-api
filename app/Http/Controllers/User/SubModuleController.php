<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\SubModuleResource;

use App\Services\SubModuleService;
use App\Services\ModuleService;

use App\Utilities;

class SubModuleController extends Controller
{
    private $subModuleService;
    private $moduleService;

    public function __construct()
    {
        $this->subModuleService = new SubModuleService;
        $this->moduleService = new ModuleService;
    }

    public function subModule($id)
    {
        try{
            if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter ID");
            $module = $this->moduleService->module($id);
            if(!$module) return Utilities::error402("Module not found");

            $subModule = $this->subModuleService->subModule($id);
            return new SubModuleResource($subModule);
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }
}
