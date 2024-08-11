<?php

namespace App\Services;

use App\Models\Module;

class ModuleService
{
    public function module($id)
    {
        return Module::find($id);
    }

    public function profileModules($profile_id)
    {
        return Module::where('profile_id', $profile_id)->get();
    }

    public function create($data)
    {
        $module = new Module;
        $module->name = $data['name'];
        $module->profile_id = $data['profileId'];
        $module->description = $data['description'];
        if(isset($data['moduleTypeId'])) $module->module_type_id = $data['moduleTypeId'];
        $module->save();
        return $module;
    }

    public function update($module, $data)
    {
        if(isset($data['name'])) $module->name = $data['name'];
        if(isset($data['description'])) $module->description = $data['description'];
        if(isset($data['module_type_id'])) $module->module_type_id = $data['module_type_id'];
        $module->update();
        return $module;
    }

    public function delete($module)
    {
        $module->delete();
    }
}


?>