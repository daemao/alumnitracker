<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $timestamps = false;
    public $translatedAttributes = ['name'];
    protected $fillable=["country_id"];

    public static function rules($id = 0)
    {
        return [
            'country_id' => 'required',
        ];
    }
    public function scopeFilter($query, $filters){
        return $query;
    }
    public  function  departments(){
        return $this->belongsToMany("App\Department","university_program_departments")
            ->withPivot("program_id");
    }
    public  function  programs(){
        return $this->belongsToMany("App\Program","university_program_departments")->distinct();
    }
    public function country(){
        return $this->belongsTo("App\Country");
    }
    public function alumni(){
        return $this->hasMany("App\AlumniInfo");
    }
}
