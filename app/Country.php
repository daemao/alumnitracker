<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['name'];
    public $timestamps = false;

    public static function rules($id = 0)
    {
        return [
            'locale' => 'required',
            'name' => 'required',
        ];
    }
}
