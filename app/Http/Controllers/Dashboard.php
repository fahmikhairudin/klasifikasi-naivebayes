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

    // public function preprocessing(Request $request)
    // {
    //     $feedback = array();
    //     return response()->json($feedback, 200, array(), JSON_PRETTY_PRINT);
    // }

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

    // public function uploadDataSet($request)
    // {
    //     $data = $this->input()->uploadDataSet($request);
    //     if($data['success'])
    //     {
    //         foreach ($data['text']['kronologi'] as $key => $value) 
    //         {
    //             $steam = $this->pre()->execute($value);
    //             $data['text']['steaming'][$key] = $steam;
    //         }
    //     }
    // }

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

    public function preprocessing()
    {
        $data = DB::table('data_train')->get();
        return view('dashboard.pre',compact('data'));
    }

    public function tfidf()
    {
        $data = DB::table('data_tf_idf')->get();
        return view('dashboard.tf-idf',compact('data'));
    }

    public function inputDataUji()
    {
        return view('dashboard.input');
    }

    public function testDdatUji(Request $request)
    {
        //insery to db
        $dataId = DB::table('data_uji')->insertGetId([
            'label'=>$request->jenis,
            'kronologi'=>$request->kronologi,
            'created_at'=>Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
        ]);
        //$dataId = 0;
        $nvb = new NaiveBayes();
        $nbc = $nvb->nbc($request->jenis,$request->kronologi);
        //dd($nbc);
        DB::table('data_uji')->where('id',$dataId)->update([
            'preprocessing' => $nbc['preprocessing'],
        ]);

        foreach ($nbc['data'] as $nbcKey => $nbcValue) 
        {
            DB::table('data_uji')->where('id',$dataId)->update([
                ''.$nbcKey.'' => $nbcValue,
            ]);
        }

         DB::table('data_uji')->where('id',$dataId)->update([
            'hasil_nbc' => $nbc['nbc'],
        ]);

         return redirect('nvb');
    }

    public function nvb()
    {
        $data = DB::table('data_uji')->get();
        if(!$data)
        {
            return redirect('home');
        }
        $prediksi = [];

        //prediksi
        $prediksi['seksual_seksual'] = DB::table('data_uji')->where('hasil_nbc','seksual')
                                ->where('label','seksual')
                                ->count();
        $prediksi['seksual_pelecehan'] = DB::table('data_uji')->where('hasil_nbc','seksual')
                                ->where('label','pelecehan')
                                ->count();
        $prediksi['seksual_kekerasan_anak'] = DB::table('data_uji')->where('hasil_nbc','seksual')
                                ->where('label','kekerasan_anak')
                                ->count();
        $prediksi['seksual_kdrt'] = DB::table('data_uji')->where('hasil_nbc','seksual')
                                ->where('label','kdrt')
                                ->count();
        $prediksi['seksual_penipuan'] = DB::table('data_uji')->where('hasil_nbc','seksual')
                                ->where('label','penipuan')
                                ->count();

        $prediksi['pelecehan_seksual'] = DB::table('data_uji')->where('hasil_nbc','pelecehan')
                                ->where('label','seksual')
                                ->count();
        $prediksi['pelecehan_pelecehan'] = DB::table('data_uji')->where('hasil_nbc','pelecehan')
                                ->where('label','pelecehan')
                                ->count();
        $prediksi['pelecehan_kekerasan_anak'] = DB::table('data_uji')->where('hasil_nbc','pelecehan')
                                ->where('label','kekerasan_anak')
                                ->count();
        $prediksi['pelecehan_kdrt'] = DB::table('data_uji')->where('hasil_nbc','pelecehan')
                                ->where('label','kdrt')
                                ->count();
        $prediksi['pelecehan_penipuan'] = DB::table('data_uji')->where('hasil_nbc','pelecehan')
                                ->where('label','penipuan')
                                ->count();

        $prediksi['kekerasan_anak_seksual'] = DB::table('data_uji')->where('hasil_nbc','kekerasan_anak')
                                ->where('label','seksual')
                                ->count();
        $prediksi['kekerasan_anak_pelecehan'] = DB::table('data_uji')->where('hasil_nbc','kekerasan_anak')
                                ->where('label','pelecehan')
                                ->count();
        $prediksi['kekerasan_anak_kekerasan_anak'] = DB::table('data_uji')->where('hasil_nbc','kekerasan_anak')
                                ->where('label','kekerasan_anak')
                                ->count();
        $prediksi['kekerasan_anak_kdrt'] = DB::table('data_uji')->where('hasil_nbc','kekerasan_anak')
                                ->where('label','kdrt')
                                ->count();
        $prediksi['kekerasan_anak_penipuan'] = DB::table('data_uji')->where('hasil_nbc','kekerasan_anak')
                                ->where('label','penipuan')
                                ->count();

        $prediksi['kdrt_seksual'] = DB::table('data_uji')->where('hasil_nbc','kdrt')
                                ->where('label','seksual')
                                ->count();
        $prediksi['kdrt_pelecehan'] = DB::table('data_uji')->where('hasil_nbc','kdrt')
                                ->where('label','pelecehan')
                                ->count();
        $prediksi['kdrt_kekerasan_anak'] = DB::table('data_uji')->where('hasil_nbc','kdrt')
                                ->where('label','kekerasan_anak')
                                ->count();
        $prediksi['kdrt_kdrt'] = DB::table('data_uji')->where('hasil_nbc','kdrt')
                                ->where('label','kdrt')
                                ->count();
        $prediksi['kdrt_penipuan'] = DB::table('data_uji')->where('hasil_nbc','kdrt')
                                ->where('label','penipuan')
                                ->count();

        $prediksi['penipuan_seksual'] = DB::table('data_uji')->where('hasil_nbc','penipuan')
                                ->where('label','seksual')
                                ->count();
        $prediksi['penipuan_pelecehan'] = DB::table('data_uji')->where('hasil_nbc','penipuan')
                                ->where('label','pelecehan')
                                ->count();
        $prediksi['penipuan_kekerasan_anak'] = DB::table('data_uji')->where('hasil_nbc','penipuan')
                                ->where('label','kekerasan_anak')
                                ->count();
        $prediksi['penipuan_kdrt'] = DB::table('data_uji')->where('hasil_nbc','penipuan')
                                ->where('label','kdrt')
                                ->count();
        $prediksi['penipuan_penipuan'] = DB::table('data_uji')->where('hasil_nbc','penipuan')
                                ->where('label','penipuan')
                                ->count();
        $dataset = DB::table('data_train')->count();
        return view('dashboard.nvb',compact('data','prediksi','dataset'));
    }

    public function nvbDelete($id)
    {
        DB::table('data_uji')->where('id',$id)->delete();
        return redirect()->back()->with('success','Berhasil menhapus data');
    }
}