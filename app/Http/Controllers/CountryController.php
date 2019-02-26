<?php

namespace App\Http\Controllers;

use App\Country;
use App\CountryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class CountryController extends Controller
{
    public function save(Request $request){
        $input_array = $request->get("translations");
        $errors=[];
        if(count($input_array) ===0) return response()->json(["errors"=>"no data specified"],422);
        foreach ($input_array as $index=>$country){
            $countryValidator = Validator::make($country, Country::rules());
            if($countryValidator->fails()){
                $errors[$index] = $countryValidator->errors();
            }
        }
        if(count($errors) === 0){
            $main_country = isset($input_array[0]["country_id"])? Country::find($input_array[0]["country_id"]):Country::create([]);
            foreach ($input_array as $index=>$country){
                $main_country->translateOrNew($country["locale"])->name=$country["name"];
            }
            $main_country->save();
            return response()->json($main_country->getTranslationsArray(),200);
        }
        else{
            return response()->json($errors,433);
        }
    }
    public function items(){
        return Country::filter(Input::all())->paginate(20);
    }
}
