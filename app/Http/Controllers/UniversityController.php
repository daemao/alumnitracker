<?php

namespace App\Http\Controllers;

use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UniversityController extends Controller
{
    public function items(Request $request){
        return University::filter(Input::all())->paginate(20);
    }
    public function save(Request $request){
        if(!$request->get("names")){
            return response()->json(["errors"=>"Names are not provided"],433);
        }
        if ($request->get("names")["en"] || $request->get("names")["ru"]){
            $university = $request->get("id")? University::find($request->get("id")):new University();
            $university->translateOrNew("en")->name=$request->get("names")["en"];
            $university->translateOrNew("ru")->name=$request->get("names")["ru"];
            if($request->get("departments")){
                $departments = $request->get("departments")->pluck("id");
                $university->departments()->sync($departments);
            }
            $university->save();
            return response()->json($university,200);
        }else{
            return response()->json(["errors"=>"Names are not provided"],433);
        }
    }
}
