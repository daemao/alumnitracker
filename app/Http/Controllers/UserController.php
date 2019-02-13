<?php

namespace App\Http\Controllers;
use App\Photo;
use Image;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //Returns administrators only(since alumni will have its own controller)
    public function items(Request $request){
        return User::where("role_id",1)->filter(Input::all())->paginate(20);
    }
    public function item(Request $request,$id){
        return User::with(["avatar","role"])->find($id);
    }

    public function save(Request $request){
        $id = $request->get('id') ? $request->get('id') : 0;
        $userValidator = Validator::make($request->all(), User::rules());
        if($userValidator->fails()){
            $errors = $userValidator->errors();
            return response()->json($errors,422);
        }else{
            $user = User::updateOrCreate(
                ['id'=>$id],
                $request->all()
            );
            return response()->json($user,200);
        }
    }

    public function updatePhoto(Request $request){
        if ($request->hasFile('photo')) {
            $user = User::find($request->get("id"));
            $image      = $request->file('photo');
            $photo_name = Storage::disk("public")->put("img",$image);
            $photo = Photo::create(["url"=>$photo_name,"user_id"=>$user->id]);
            $user->avatar_id = $photo->id;
            $user->save();
            return User::with(["avatar","role"])->find($user->id);
        }
    }


}
