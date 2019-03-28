<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function items(Request $request){
        app()->setLocale($request->user()->locale);
        return Department::filter(Input::all())->with(['alumnis',"universities"])->paginate(20);
    }
    public function item(Request $request,$id){
        app()->setLocale($request->user()->locale);
        return Department::with(['alumnis',"universities"])->find($id);
    }

    public function remove(Request $request,$id){
        return Department::where("id",$id)->delete();
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
    public function attachDepartmentsToUniversity(Request $request){
        $validator = Validator::make($request->all(), [
            'university_id' => 'required',
            'department_id' => 'required',
            'selected_programs' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),433);
        }else{
            $selected_programs = $request->get("selected_programs");
            foreach ($selected_programs as $program){
                $count = DB::table("university_program_departments")
                    ->where("university_id",$request->get("university_id"))
                    ->where("department_id",$request->get("department_id"))
                    ->where("program_id",$program)->count();
                if($count == 0){
                    DB::table("university_program_departments")->insert([
                        "university_id"=>$request->get("university_id"),
                        "department_id"=>$request->get("department_id"),
                        "program_id"=>$program
                    ]);
                }

            }
            return response()->json(["status"=>"success"],200);
        }
    }
}
