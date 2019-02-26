<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DepartmentController extends Controller
{
    public function items(Request $request){
        app()->setLocale($request->user()->locale);
        return Department::filter(Input::all())->paginate(20);
    }
    public  function  save(Request $request){
        $en = $request->get("en");
        $ru = $request->get("ru");
        if(!$ru && !$en) return response()->json(["names should be provided"],433);
        else{
            $department = $request->get("id")? Department::find($request->get("id")):new Department();
            $department->translateOrNew("en")->name=$en;
            $department->translateOrNew("ru")->name=$ru;
            $department->save();
            return response()->json($department,200);
        }
    }
}
