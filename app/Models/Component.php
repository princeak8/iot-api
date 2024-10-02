<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo("App\Models\ComponentCategory", "category_id", "id");
    }

    public function subModule()
    {
        return $this->belongsTo("App\Models\SubModule");
    }

    public function parameters()
    {
        return $this->belongsToMany('App\Models\Parameter', 'App\Models\ComponentParameter', 'component_id', 'parameter_id');
    }
}
