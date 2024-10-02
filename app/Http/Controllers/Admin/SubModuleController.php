<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Events\PublishData;

use App\Http\Requests\CreateSubModule;

use App\Http\Resources\SubModuleResource;

use App\Services\SubModuleService;
use App\Utilities;

class SubModuleController extends Controller
{
    private $subModuleService;

    public function __construct()
    {
        $this->subModuleService = new SubModuleService;
    }

    public function create(CreateSubModule $request)
    {
        try{
            $data = $request->validated();
            $subModule = $this->subModuleService->create($data);

            return Utilities::okay(new SubModuleResource($subModule));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function subModules($moduleId)
    {
        if (!is_numeric($moduleId) || !ctype_digit($moduleId)) return Utilities::error402("Invalid parameter module Id");
        $subModules = $this->subModuleService->subModules($moduleId);

        return Utilities::okay(SubModuleResource::collection($subModules));
    }

    public function subModule($id)
    {
        if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter Id");
        $subModule = $this->subModuleService->subModule($id);
        if(!$subModule) return Utilities::error402("SubModule not found");
        // event(new PublishData("5A", $subModule->topic));
        return Utilities::okay(new SubModuleResource($subModule));
    }
}
