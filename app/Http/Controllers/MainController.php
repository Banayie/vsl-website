<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return redirect()->route('study');
    }

    public function study()
    {
        return view('study');
    }

    public function dictionary()
    {
        return view('dictionary');
    }

    public function translator()
    {
        return view('translator');
    }

    public function profile()
    {
        return view('profile');
    }
}