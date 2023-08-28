<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
//model
use App\Models\Input;
use App\Models\Pre;
use App\Models\TfIdf;
use App\Models\NaiveBayes;
use App\Models\Laporan;
use DB;
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
        $data = DB::table('data_train')->orderBy('created_at','DESC')->get();
        return view('dashboard.data_latih',compact('data'));
    }

    public function uploadDataSet($request)
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
       DB::table('data_train')->insert([
            'label'=>$request->label,
            'kronologi'=>$request->kronologi,
            'created_at'=>Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
        ]);

       return redirect()->back()->with('success','Berhasil menambahkan data latih');
    }

    public function deleteDataset($id)
    {
        DB::table('data_train')->where('id',$id)->delete();
        return redirect()->back()->with('success_hapus','Berhasil hapus data latih silahkan latih ulang data anda');
    }

    public function inputDataSetTrain(Request $request)
    {
        $latih = DB::table('data_train')->get();
        $data = $this->pre()->execute($latih);
        return redirect()->back()->with('success','Berhasil melatih data silahkan lanjut lihat hasil di preprocessing');
    }
}