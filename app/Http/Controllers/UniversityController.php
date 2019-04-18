<?php

namespace App\Http\Controllers;

use App\Country;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UniversityController extends Controller
{
    public function items(Request $request){
        return University::filter(Input::all())->with(['country'])->paginate(20);
    }
    public function save(Request $request){
        $errors=[];
        $validator = Validator::make($request->all(), Country::rules());
        if($validator->fails()){
            array_merge($errors,$validator->errors()->toArray());
        }
        if(!$request->get("names")){
            array_merge($errors,["names are not defined"]);
        }else{
            if (!$request->get("names")["en"] && !$request->get("names")["ru"]){
                array_merge($errors,["names are not defined"]);
            }
        }
        if (count($errors)==0){
            $university = $request->get("id")? University::find($request->get("id")):new University();
            $ru_name=trim($request->get("names")["ru"]);
            $en_name=trim($request->get("names")["en"]);
            if($ru_name!="" ){
                $university->translateOrNew("ru")->name=$ru_name;
            }
            if($en_name !=""){
                $university->translateOrNew("en")->name=$en_name;
            }
            $university->country_id = $request->get("country_id");
            $university->save();
            if($request->get("departments")){
                $departments = array_column($request->get("departments"),"id");
                $university->departments()->sync($departments);
            }
            return response()->json($university,200);
        }else{
            return response()->json($errors,433);
        }
    }
    public function item($id,Request $request){
        $university = University::with(["country","departments","programs"])->find($id);
        $university->alumni_number = $university->alumni()->count();
        return response()->json($university,200);
    }
    public function remove(Request $request){
        return University::where("id",$request->get("university_id"))->delete();
    }
}
