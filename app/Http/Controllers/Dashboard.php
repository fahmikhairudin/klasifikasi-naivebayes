<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    //

    public function index()
    {
        return view('dashboard.index');
    }

    public function preprocessing(Request $request)
    {
        $feedback = array();
        return response()->json($feedback, 200, array(), JSON_PRETTY_PRINT);
    }
}