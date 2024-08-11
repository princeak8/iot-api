<?php

namespace App\Services;

use App\Models\Parameter;

class ParameterService
{
    public function parameter($id)
    {
        return Parameter::find($id);
    }

    public function parameters()
    {
        return Parameter::all();
    }

    public function create($data)
    {
        $parameter = new Parameter;
        $parameter->name = $data['name'];
        $parameter->unit = $data['unit'];
        $parameter->save();
        return $parameter;
    }

    public function update($parameter, $data)
    {
        if(isset($data['name'])) $parameter->name = $data['name'];
        $parameter->update();
        return $parameter;
    }
}


?>