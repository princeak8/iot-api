<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Profile extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function modules()
    {
        return $this->hasMany("App\Models\modules");
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'App\Models\ProfileUser', 'profile_id', 'user_id');
    }
}
