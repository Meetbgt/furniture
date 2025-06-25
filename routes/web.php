<?php

use App\Http\Controllers\Webpage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home',[Webpage::class,'home'])->name('home');
Route::get('/aboutus',[Webpage::class,'aboutus'])->name('aboutus');
Route::get('/contactus',[Webpage::class,'contactus'])->name('contactus');
Route::get('/services',[Webpage::class,'services'])->name('services');
Route::get('/admin',[Webpage::class,'admin'])->name('admin');
// Route::get('/home',[Webpage::class,'index'])->name('home');
