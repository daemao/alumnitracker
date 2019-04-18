<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable=["email",'current_university_id','current_company_id',"password","first_name","last_name","role_id","socials_fb","socials_github","socials_vk","socials_twitter"];
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
        if(isset($filters["current_user"])){
            $user_id = $filters["current_user"];
            $query->whereDoesntHave ("followings",function ($q) use($user_id){
                $q->where("user_id",$user_id);
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
    public function toArray()
    {
        $array = parent::toArray();

        return $array;
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
    public function work_experience(){
        return $this->hasMany("App\WorkExperience");
    }
    public function achievements(){
        return $this->hasMany("App\Achievement");
    }
    public function photos(){
        return $this->hasMany("App\Photo","user_id");
    }

    public function current_company(){
        return $this->hasOne("App\WorkExperience")->orderBy("id","desc");
    }
    public function current_university(){
        return $this->hasOne("App\AlumniInfo")->orderBy("id","desc");

    }

    public function followers(){
        return  $this->belongsToMany("App\User","friends","friend_id","user_id");
    }
    public function followings(){
        return  $this->belongsToMany("App\User","friends","user_id","friend_id");
    }

    function inputFriendRequest(){
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id')
            ->wherePivot('accepted', '=', 0);
    }
    function outputFriendRequest(){
        return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id')
            ->wherePivot('accepted', '=', 0);
    }


}
