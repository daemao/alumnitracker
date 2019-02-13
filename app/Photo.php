<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table="photos";
    public $timestamps=false;
    protected $fillable=["user_id","url"];
}
