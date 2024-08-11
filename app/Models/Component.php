<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    public function componentGroups() 
    {
        return $this->hasMany("App\Models\ComponentGroup", "component_id", "id");
    }

    public function category()
    {
        return $this->belongsTo("App\Models\ComponentCategory", "category_id", "id");
    }
}
