<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable=["email","password","first_name","last_name","role_id"];
    protected $hidden=["password"];

    public function scopeFilter($query, $filters){
        if (isset($filters['text'])) {
            $search_text = $filters['text'];
            $query->where(function ($query) use ($search_text) {
                $query->where('first_name', 'like', '%' . $search_text . '%');
                $query->orWhere('email', 'like', '%' . $search_text . '%');
                $query->orWhere('last_name', 'like', '%' . $search_text . '%');
            });
        }
        return $query;
    }
    public static function rules($id = 0)
    {
        return [
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'role_id' => 'exists:roles,id',
        ];
    }
    public function avatar(){
        return  $this->hasOne("App\Photo","id","avatar_id");
    }
    public function role(){
        return $this->belongsTo("App\Role");
    }

    public function findForPassport($user)
    {
        return $this->where('email', $user)->first();
    }
    public function alumni_info(){
        return $this->hasMany("App\AlumniInfo");
    }
    public function photos(){
        return $this->hasMany("App\Photo","user_id");
    }


}
