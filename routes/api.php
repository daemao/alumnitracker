<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//здесь запросы на АПИ
Route::get("/data","Controller@data");

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //user related
    Route::get("/users","UserController@items");
    Route::get("/user/{id}",'UserController@item');
    Route::post("/user/save","UserController@save");
    Route::post("/update-user-photo","UserController@updatePhoto");

    //country related
    Route::post("/country/save","CountryController@save");
    //university related
    Route::get("/universities","UniversityController@items");
    Route::post("/university/save","UniversityController@save");
    //department related
});
