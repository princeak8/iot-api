<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryParameter extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'parameter_id'];

    public function category()
    {
        return $this->belongsTo("App\Models\ComponentCategory");
    }

    public function parameter()
    {
        return $this->belongsTo("App\Models\Parameter");
    }
}
