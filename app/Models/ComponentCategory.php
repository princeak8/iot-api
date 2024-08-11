<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentCategory extends Model
{
    use HasFactory;

    public function categoryParameters() 
    {
        return $this->hasMany("App\Models\ComponentCategoryParameter", "category_id", "id");
    }

    public function parameters()
    {
        return $this->belongsToMany('App\Models\Parameter', 'App\Models\ComponentCategoryParameter', 'category_id', 'parameter_id');
    }
}
