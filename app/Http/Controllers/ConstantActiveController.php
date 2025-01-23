<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConstantActiveController extends Controller
{
    public function index(Request $request)
    {
        return view('constant-active');
    }
}
