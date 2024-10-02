<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubModule extends Model
{
    use HasFactory;

    public function module()
    {
        return $this->hasMany("App\Models\Module");
    }

    public function components()
    {
        return $this->hasMany("App\Models\Component");
    }

}
