<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany("App\Models\ComponentCategory", "category_parameters");
    }

    public function categoryParameters()
    {
        return $this->hasMany("App\Models\CategoryParameter", "parameter_id", "id");
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (Parameter $parameter) {
            if($parameter->categoryParameters->count() > 1) {
                foreach($parameter->categoryParameters as $categoryParameter) $categoryParameter->delete();
            }
        });
    }
}
