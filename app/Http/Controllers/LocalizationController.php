<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function index($localize
    )
    {
        app()->setLocale($localize);


        return view('local');


    }
}
