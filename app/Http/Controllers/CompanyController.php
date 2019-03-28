<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CompanyController extends Controller
{
    public function items(){
        return Company::filter(Input::all())->paginate(20);
    }
    public function save(Request $request){
        $company = $request->get("id")? Company::find($request->get("id")):new Company();
        $lang = $request->user()->lang;
        $company->translateOrNew($lang)->name=$request->get("name");
        $company->save();
    }
}
