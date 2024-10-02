<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Model
{
    use HasFactory, Notifiable;

    public function users()
    {
        return $this->hasMany("App\Models\User");
    }

    public function profiles()
    {
        return $this->hasMany("App\Models\Profile");
    }
}
