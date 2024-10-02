<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentParameter extends Model
{
    use HasFactory;

    public function component()
    {
        return $this->belongsTo("App\Models\Component");
    }

    public function parameter()
    {
        return $this->belongsTo("App\Models\Parameter");
    }
}
