<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Webpage extends Controller
{
    public function home()
    {
        return view('index');
    }

    public function aboutus()
    {
        return view('about');
    }

    public function contactus()
    {
        return view('contact');
    }

    public function services()
    {
        return view('services');
    }

    public function shop()
    {
        return view('shop');
    }

    public function admin()
    {
        return view('admin/template');
    }
}
