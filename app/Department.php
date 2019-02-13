<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['name'];
    public $timestamps = false;
}
