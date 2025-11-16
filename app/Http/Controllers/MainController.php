<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class MainController extends Controller
{
    public function index()
    {
        return redirect()->route('study');
    }
    public function dictionary()
    {
        return view('dictionary');
    }

    public function translator()
    {
        return view('translator');
    }
    // Profile
    public function profile()
    {
        return view('profile');
    }
   


}