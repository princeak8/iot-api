<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Resources\ComponentCategoryResource;

use App\Services\ComponentCategoryService;

use App\Http\Requests\CreateComponentCategory;
use App\Http\Requests\UpdateComponentCategory;

use App\Utilities;

class ComponentCategoryController extends Controller
{
    private $categoryService;

    public function __construct()
    {
        $this->categoryService = new ComponentCategoryService;
    }

    public function create(CreateComponentCategory $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->validated();
            $category = $this->categoryService->create($data);
            DB::commit();
            return Utilities::okay(new ComponentCategoryResource($category));
        }catch(\Exception $e){
            DB::rollBack();
            return Utilities::error($e);
        }
    }

    public function update(UpdateComponentCategory $request)
    {
        try {
            $data = $request->validated();
            $category = $this->categoryService->category($data['id']);
            if(!$category) return Utilities::error402('Category not found');

            if($category->module_id) {
                $moduleId = (isset($data['moduleId'])) ? $data['moduleId'] : $category->module_id;
                $count = $this->categoryService->categoryByNameAndModuleId($category->name, $moduleId)->count();
                if((isset($data['moduleId']) && $count > 0) || (!isset($data['moduleId']) && $count > 1)) {
                    return Utilities::error402("Category name exists for this module");
                }
            }

            $category = $this->categoryService->update($data, $category);
            return Utilities::okay(new ComponentCategoryResource($category));
        } catch (\Exception $e) {
            return Utilities::error($e);
        }
    }

    public function category($id)
    {
        try {
            if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter ID");
            $category = $this->categoryService->category($id);
            if(!$category) return Utilities::error402('Category not found');

            return Utilities::okay(new ComponentCategoryResource($category));
        } catch (\Exception $e) {
            return Utilities::error($e);
        }
    }

    public function categories()
    {
        try {
            $categories = $this->categoryService->categories();
            return Utilities::okay(ComponentCategoryResource::collection($categories));
        } catch (\Exception $e) {
            return Utilities::error($e);
        }
    }

    public function delete($id)
    {
        try {
            if (!is_numeric($id) || !ctype_digit($id)) return Utilities::error402("Invalid parameter ID");
            $category = $this->categoryService->category($id);
            if(!$category) return Utilities::error402('Category not found');

            $this->categoryService->delete($id);
            return Utilities::okay(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return Utilities::error($e);
        }
    }

    
}
