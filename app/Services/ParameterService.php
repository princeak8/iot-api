<?php

namespace App\Services;

use App\Models\Parameter;

class ParameterService
{
    public function parameter($id, $with=[])
    {
        return Parameter::with([])->where('id', $id)->first();
    }

    public function parameters($with=[])
    {
        return Parameter::with($with)->get();
    }

    public function create($data)
    {
        $parameter = new Parameter;
        $parameter->name = $data['name'];
        $parameter->unit = $data['unit'];
        $parameter->profile_id = $data['profileId'];
        if(isset($data['moduleId'])) $parameter->module_id = $data['moduleId'];
        $parameter->save();
        return $parameter;
    }

    public function update($data, $parameter)
    {
        if(isset($data['name'])) $parameter->name = $data['name'];
        if(isset($data['unit'])) $parameter->unit = $data['unit'];
        if(isset($data['profileId'])) $parameter->profile_id = $data['profileId'];
        if(isset($data['moduleId'])) $parameter->module_id = $data['moduleId'];
        $parameter->update();
        return $parameter;
    }

    public function delete($parameter)
    {
        $parameter->categories->delete();
    }
}


?>