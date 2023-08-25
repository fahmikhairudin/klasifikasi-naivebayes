<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
//model
use App\Models\Input;
use App\Models\Pre;
use App\Models\TfIdf;
use App\Models\NaiveBayes;
use App\Models\Laporan;
class Dashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard.index');
    }

    public function preprocessing(Request $request)
    {
        $feedback = array();
        return response()->json($feedback, 200, array(), JSON_PRETTY_PRINT);
    }

    //input data area
    //load model 
    public function input()
    {
        $data = new Input();
        return $data;
    }

    public function pre()
    {
        $data = new Pre();
        return $data;
    }

    //end load model
    public function inputIndex()
    {
        return view('dashboard.input');
    }

    public function uploadDataSet(Request $request)
    {
        $data = $this->input()->uploadDataSet($request);
        if($data['success'])
        {
            foreach ($data['text']['kronologi'] as $key => $value) 
            {
                $steam = $this->pre()->execute($value);
                $data['text']['steaming'][$key] = $steam;
            }
        }
    }

    public function inputDataSet(Request $request)
    {
        $data = $this->pre()->execute($request->text);
        dd($data);
    }
}