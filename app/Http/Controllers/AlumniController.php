<?php

namespace App\Http\Controllers;
use App\AlumniInfo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Validator;

class AlumniController extends Controller{

    public function items(){
        return User::where("role_id",2)->with(["alumni_info"])->filter(Input::all())->paginate(20);
    }
    public function item(Request $request,$id){
        return User::with(["avatar","alumni_info.program","alumni_info.department"])->find($id);
    }
    public function createAlumniInfo(Request $request){
        $validator = Validator::make($request->all(), [
            'cumulative_gpa' => 'required',
            'university_id' => 'required',
            'id_in_university' => 'required',
            'graduate_year' => 'required',
            'program_id' => 'required',
            'department_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),433);
        }else{
            AlumniInfo::create($request->all());
        }
    }

}
