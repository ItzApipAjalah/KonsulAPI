<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AdminIndex(){
        return view('layouts.admin.home');
    } 

    public function GuruIndex(){
        return view('layouts.guru.home');
    }

    public function SiswaIndex(){
        return view('layouts.siswa.home');
    }
}
