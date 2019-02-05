<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable=["email","password","first_name","last_name"];

    public function role(){
        return $this->belongsTo("App\Role");
    }
    public function findForPassport($user)
    {
        return $this->where('email', $user)->first();
    }
}
