<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app');
});
Route::get('/login', function () {
    return view('app');
});
// это чтобы сервер находил страницу в браузере
Route::get('/administrators', function () {
    return view('app');
});
Route::get('/administrators/{id}', function () {
    return view('app');
});
Route::get('/dashboard', function () {
    return view('app');
});
Route::get('/companies', function () {
    return view('app');
});
Route::get('/companies/{id}', function () {
    return view('app');
});
Route::get('/alumni', function () {
    return view('app');
});
Route::get('/alumni/{id}', function () {
    return view('app');
});
Route::get('/universities', function () {
    return view('app');
});
Route::get('/universities/{id}', function () {
    return view('app');
});
Route::get("/countries",function (){
   return view("app");
});
Route::get("/departments",function (){
   return view("app");
});
Route::get("/department/{id}",function (){
    return view("app");
});
Route::get("/profile/{id}", function(){
    return view("app");
});



