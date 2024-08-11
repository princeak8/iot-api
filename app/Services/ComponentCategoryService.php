<?php

namespace App\Services;

use App\Models\ComponentCategory;
use App\Models\ComponentCategoryParameter;

use App\Services\ParameterService;

class ComponentCategoryService
{
    public function category($id)
    {
        return ComponentCategory::find($id);
    }

    public function categories($moduleId)
    {
        return ComponentCategory::where('module_id', $moduleId);
    }

    public function create($data)
    {
        $componentCategory = new ComponentCategory;
        $componentCategory->name = $data['name'];
        $componentCategory->moduleId = $data['moduleId'];
        $componentCategory->save();
        // Saving component category parameters
        $parameters = [];
        $parameterService = new ParameterService;
        foreach($data['parameterIds'] as $parameterId) $parameters[] = $parameterService->parameter($parameterId);
        $componentCategory->categoryParameters->saveMany($parameters);
        return $componentCategory;
    }

    public function update($componentCategory, $data)
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


}


?>