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
    public function scopeFilter($query, $filters){
        if (isset($filters['text'])) {
            $search_text = $filters['text'];
            $query->where(function ($query) use ($search_text) {
                $query->whereTranslationLike("name",'%' . $search_text . '%');
            });
        }
        return $query;
    }
}
