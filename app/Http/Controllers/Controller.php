<?php

namespace App\Http\Controllers;

use App\Country;
use App\Department;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function data(Request $request){
        $data = [];
        $data["nu_departments"] = Department::find(1)->with("departments");
        return response()->json($data,200);
    }
}
