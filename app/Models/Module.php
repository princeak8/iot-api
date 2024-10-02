<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    public function subModules() 
    {
        return $this->hasMany("App\Models\SubModule");
    }

    public function type()
    {
        return $this->belongsTo("App\Models\ModuleType");
    }

    protected static function boot(){
        parent::boot();
    
        static::deleted(function($module)
        {
            foreach($module->components as $component) {
                $component->delete();
            }
        });
    }
}
