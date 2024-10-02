<?php

namespace App\Services;

use App\Models\SubModule;

class SubModuleService
{
    public function subModule($id)
    {
        return SubModule::find($id);
    }

    public function subModules($module_id)
    {
        return SubModule::where('module_id', $module_id)->get();
    }

    public function create($data)
    {
        $subModule = new SubModule;
        $subModule->name = $data['name'];
        $subModule->module_id = $data['moduleId'];
        if(isset($data['description'])) $subModule->description = $data['description'];
        if(isset($data['topic'])) $subModule->topic = $data['topic'];
        $subModule->save();
        return $subModule;
    }

    public function update($subModule, $data)
    {
        if(isset($data['name'])) $subModule->name = $data['name'];
        if(isset($data['description'])) $subModule->description = $data['description'];
        if(isset($data['topic'])) $subModule->topic = $data['topic'];
        $subModule->update();
        return $subModule;
    }

    public function delete($subModule)
    {
        $subModule->delete();
    }
}


?>