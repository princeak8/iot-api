<?php

namespace App\Services;

use App\Models\ComponentCategory;
use App\Models\CategoryParameter;

use App\Services\ParameterService;

class ComponentCategoryService
{
    public function category($id)
    {
        return ComponentCategory::find($id);
    }

    public function categoryByNameAndModuleId($name, $moduleId)
    {
        return ComponentCategory::where('name', $name)->where('module_id', $moduleId)->get();
    }

    public function categories()
    {
        return ComponentCategory::all();
    }

    public function create($data)
    {
        $componentCategory = new ComponentCategory;
        $componentCategory->name = $data['name'];
        if(isset($data['description'])) $componentCategory->description = $data['description'];
        // $componentCategory->profile_id = $data['profileId'];
        $componentCategory->save();
        // Saving component category parameters
        foreach($data['parameterIds'] as $parameterId) {
            CategoryParameter::create([
                'category_id' => $componentCategory->id,
                'parameter_id' => $parameterId
            ]);
        }
        return $componentCategory;
    }

    public function update($data, $componentCategory)
    {
        if(isset($data['name'])) $componentCategory->name = $data['name'];
        if(isset($data['moduleId'])) $componentCategory->moduleId = $data['moduleId'];
        $componentCategory->update();
        return $componentCategory;
    }

    public function addParameters(Array $parametersId, Number $categoryId) 
    {
        foreach($parametersId as $parameterId) {
            $categoryParameter = new ComponentCategoryParameter;
            $categoryParameter->category_id = $categoryId;
            $categoryParameter->parameter_id = $parameterId;
            $categoryParameter->save();
        }
    }

    // Detach a parameter from a ComponentCategory
    public function removeParameters(Array $parametersId, ComponentCategory $category)
    {
        foreach($category->categoryParameters as $categoryParameter) {
            if(in_array($categoryParameter->parameterId, $parametersId)) $categoryParameter->delete();
        }
    }

    public function delete($category)
    {
        $category->delete();
    }


}


?>