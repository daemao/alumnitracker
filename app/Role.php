<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $timestamps = false;
    protected $fillable = ['original_name'];
    public $translatedAttributes = ['name'];


}
