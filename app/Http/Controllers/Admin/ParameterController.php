<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\CreateParameter;
use App\Http\Requests\UpdateParameter;
use Illuminate\Http\Request;

use App\Http\Resources\ParameterResource;

use App\Utilities;

use App\Services\ParameterService;

class ParameterController extends Controller
{
    private $parameterService;

    public function __construct()
    {
        $this->parameterService = new ParameterService;
    }

    public function create(CreateParameter $request)
    {
        try{
            $data = $request->validated();
            $data['profileId'] = Auth::guard('profile')->user()->id;
            $parameter = $this->parameterService->create($data);
            return Utilities::okay(new ParameterResource($parameter));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function update(UpdateParameter $request)
    {
        try{
            $data = $request->validated();
            $parameter = $this->parameterService->parameter($data['id']);
            if(!$parameter) return Utilities::error402("parameter not found");

            $parameter = $this->parameterService->update($data, $parameter);
            return Utilities::okay(new ParameterResource($parameter));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function parameters()
    {
        try{
            $parameters = $this->parameterService->parameters();
            return Utilities::okay(ParameterResource::collection($parameters));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function parameter($id)
    {
        try{
            if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter ID");
            
            $parameter = $this->parameterService->parameter($id);
            if(!$parameter) return Utilities::error402("parameter not found");

            return Utilities::okay(new ParameterResource($parameter));
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }

    public function delete($id)
    {
        try{
            if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter ID");

            $parameter = $this->parameterService->parameter($id);
            if(!$parameter) return Utilities::error402("parameter not found");

            $this->parameterService->delete($parameter);
            return Utilities::okay("parameter deleted Successfully");
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }
}
