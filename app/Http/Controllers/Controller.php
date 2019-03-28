<?php

namespace App\Http\Controllers;

use App\AlumniInfo;
use App\Company;
use App\Country;
use App\Department;
use App\Program;
use App\University;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
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
        $data["universities"]=University::all();
        $data["departments"]=Department::all();
        $data["countries"]=Country::all();
        $data["companies"]=Company::all();
        return response()->json($data,200);
    }
    //get the number of alumni graduate each year
    public function getAlumniTrend(){
        return AlumniInfo::all();
    }
}
