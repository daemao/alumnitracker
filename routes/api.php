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

    //dashboard related
    Route::get("/dashboard/alumni-trend","Controller@getAlumniTrend");


    //user related
    Route::get("/users","UserController@items");
    Route::get("/user/{id}",'UserController@item');
    Route::post("/user/save","UserController@save");
    Route::post("/update-user-photo","UserController@updatePhoto");
    Route::post("/change-locale","UserController@changeLocale");

    //alumni related
    Route::get("/alumni","AlumniController@items");
    Route::post("/alumni/save-alumni-info","AlumniController@createAlumniInfo");
    Route::post("/alumni/save-work-experience","AlumniController@createWorkExperience");
    Route::post("/alumni/save-achievement","AlumniController@createAchivement");
    Route::get("/alumni/{id}/followers","AlumniController@getFollowers");
    Route::get("/alumni/{id}/followings","AlumniController@getFollowings");
    Route::get("/alumni/get-list-to-follow","AlumniController@getAvailableFollowers");
    Route::post('/alumni/start-follow',"AlumniController@startFollow");


    Route::get("/alumni/{id}","AlumniController@item");
    Route::post("/alumni/export-spreadsheet","AlumniController@exportAlumniSpreadsheet");
    //country related
    Route::get("/countries","CountryController@items");
    Route::post("/country/save","CountryController@save");
    //university related
    Route::get("/universities","UniversityController@items");
    Route::get("/university/{id}","UniversityController@item");
    Route::post("/university/save","UniversityController@save");
    Route::post("/university-remove","UniversityController@remove");

    //department related
    Route::get("/departments","DepartmentController@items");
    Route::get("/department/{id}","DepartmentController@item");
    Route::get("/department/remove/{id}","DepartmentController@remove");
    Route::post("/department/save","DepartmentController@save");
    Route::post("/add-university-department","DepartmentController@attachDepartmentsToUniversity");
    //Company related stuff
    Route::get("/companies","CompanyController@items");
    Route::post("/company/save","CompanyController@save");
});
