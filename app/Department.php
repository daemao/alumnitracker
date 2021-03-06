<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['name'];
    public $timestamps = false;
    public function scopeFilter($query, $filters){
        if (isset($filters['text'])) {
            $search_text = $filters['text'];
            $query->where(function ($query) use ($search_text) {
                $query->whereTranslationLike("name",'%' . $search_text . '%');
            });
        }
        return $query;
    }

    public  function  universities(){
        return $this->belongsToMany("App\University","university_program_departments")
            ->withPivot("program_id");
    }

    public function alumnis(){
        return $this->hasMany("App\AlumniInfo","department_id");
    }
}
