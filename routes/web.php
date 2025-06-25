<?php

use App\Http\Controllers\Webpage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home_header;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home',[Webpage::class,'home'])->name('home');
Route::get('/aboutus',[Webpage::class,'aboutus'])->name('aboutus');
Route::get('/contactus',[Webpage::class,'contactus'])->name('contactus');
Route::get('/services',[Webpage::class,'services'])->name('services');
Route::get('/admin',[Webpage::class,'admin'])->name('admin');




Route::GET("home_header", [Home_header::class, "index"])->name("home_header");
Route::post("home_header_insert", [Home_header::class, "home_header_insert"])->name("home_header_insert");
Route::GET("/home_header_list", [Home_header::class, "home_header_list"])->name("home_header_list");
Route::post("/home_header_getdata", [Home_header::class, "home_header_getdata"])->name("home_header_getdata");
Route::post("/home_header_delete", [Home_header::class, "home_header_delete"])->name("home_header_delete");
// Route::get('/home',[Webpage::class,'index'])->name('home');
