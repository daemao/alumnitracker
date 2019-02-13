<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $timestamps = false;
    public $translatedAttributes = ['name'];

    public function scopeFilter($query, $filters){
        
        return $query;
    }
}
