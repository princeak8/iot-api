<?php

namespace App\Services;

use App\Models\Component;

class ComponentService
{
    public function component($id)
    {
        return Component::find($id);
    }

    public function components($subModuleId)
    {
        return Component::where('sub_module_id', $subModuleId)->get();
    }

    public function categoryComponents($categoryId)
    {
        return Component::where('category_id', $categoryId)->get();
    }

    public function create($data)
    {
        $component = new Component;
        $component->name = $data['name'];
        $component->code_name = $data['codeName'];
        $component->category_id = $data['categoryId'];
        $component->sub_module_id = $data['subModuleId'];
        if(isset($data['actionable'])) $component->actionable = $data['actionable'];
        if(isset($data['topic'])) $component->sub_topic = $data['topic'];
        $component->save();
        return $component;
    }

    public function update($component, $data)
    {
        if(isset($data['name'])) $component->name = $data['name'];
        if(isset($data['identifier'])) $component->identifier = $data['identifier'];
        if(isset($data['categoryId'])) $component->category_id = $data['categoryId'];
        if(isset($data['moduleId'])) $component->module_id = $data['moduleId'];
        if(isset($data['topic'])) $component->sub_topic = $data['topic'];
        $component->update();
        return $component;
    }
}


?>