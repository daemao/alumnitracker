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
    Route::post("/change-locale","UserController@changeLocale");

    //alumni related
    Route::get("/alumni","AlumniController@items");
    Route::post("/alumni/save-alumni-info","AlumniController@createAlumniInfo");
    Route::get("/alumni/{id}","AlumniController@item");
    //country related
    Route::get("/countries","CountryController@items");
    Route::post("/country/save","CountryController@save");
    //university related
    Route::get("/universities","UniversityController@items");
    Route::get("/university/{id}","UniversityController@item");
    Route::post("/university/save","UniversityController@save");
    //department related
    Route::get("/departments","DepartmentController@items");
    Route::post("/department/save","DepartmentController@save");
    Route::post("/add-university-department","DepartmentController@attachDepartmentsToUniversity");
});
