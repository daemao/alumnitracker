<?php

namespace App\Http\Controllers;

use App\Country;
use App\Department;
use App\Program;
use App\University;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Constraint\Count;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function data(Request $request){
        $data = [];
        $nu = University::find(1);
        $data["nu_departments"]=$nu->departments;
        $data["nu_programs"]=$nu->programs;
        $data["programs"]=Program::all();
        $data["departments"]=Department::all();
        $data["countries"]=Country::all();
        return response()->json($data,200);
    }
}
