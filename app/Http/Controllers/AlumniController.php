<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AlumniController extends Controller{

    public function items(){
        return User::where("role_id",2)->filter(Input::all())->paginate(20);
    }

}
