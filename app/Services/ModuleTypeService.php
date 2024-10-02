<?php

namespace App\Services;

use App\Models\ModuleType;

class ModuleTypeService
{
    public function type($id)
    {
        return ModuleType::find($id);
    }

    public function types()
    {
        return ModuleType::all();
    }

    public function create($data)
    {
        $moduleType = new ModuleType;
        $moduleType->name = $data['name'];
        $moduleType->save();
        return $moduleType;
    }

    public function update($type, $data)
    {
        if(isset($data['name'])) $type->name = $data['name'];
        $type->update();
        return $type;
    }
}


?>