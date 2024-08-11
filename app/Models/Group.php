<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function componentGroups() 
    {
        return $this->hasMany("App\Models\ComponentGroup", "group_id", "id");
    }

    public function components()
    {
        return $this->belongsToMany('App\Models\Component', 'App\Models\ComponentGroup', 'group_id', 'component_id');
    }
}
