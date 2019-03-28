<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumniInfo extends Model
{
    protected $table = "alumni_info";
    public $timestamps = false;
    protected $fillable=["user_id","department_id","graduate_year","program_id","university_id"];
    public function program(){
        return $this->belongsTo("App\Program");
    }
    public function department(){
        return $this->belongsTo("App\Department");
    }
    public function university(){
        return $this->belongsTo("App\University");
    }
}
