<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class ContestantActiveController extends Controller
{
 
    public function index(Request $request)
    {
 
        return view('contestant-active');
    }
}
