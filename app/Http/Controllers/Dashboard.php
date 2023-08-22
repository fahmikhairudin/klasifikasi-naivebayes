<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shuchkin\SimpleXLSX;
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

    public function uploadDataSet(Request $request)
    {
        $response = [];
        $file = $this->uploadFile($request,'data_set');
        $xlsx =SimpleXLSX::parse(public_path('/assets/data_set/'.$file));
        $ff = $xlsx->rows();
        //validasi excel file tahap 1
        foreach ( $ff as $k => $r ) 
        {
            if ( $k === 0 ) {
                $header_values = $r;
                continue;
            }
            $rows[] = array_combine( $header_values, $r );
        }
        $result = $rows;
        $total = count($result) - 1;
        if(is_array($result))
        {
            if(isset($result[0]))
            {
                if(isset($result[0]['KRONOLOGI']))
                {
                    $response['success'] = true;
                    $response['data'] = '';
                    $response['message'] = 'Berhasil Membaca Data Set';

                    foreach ($result as $key => $value) 
                    {
                        if($key < $total)
                        {
                            $response['data'] .= $value['KRONOLOGI']."\xA";
                        }
                        $response['data'] .= $value['KRONOLOGI'];
                    }
                    return response()->json($response);
                }else
                {
                    $response['success'] = false;
                    $response['data'] = '';
                    $response['message'] = 'Data kolom KRONOLOGI tidak terbaca mohon periksa data set';
                    return response()->json($response);
                }
            }else
            {
                $response['success'] = false;
                $response['data'] = '';
                $response['message'] = 'Data kolom tidak terbaca mohon periksa data set';
                return response()->json($response);
            }
        }else{
            $response['success'] = false;
            $response['data'] = '';
            $response['message'] = 'Data tidak terbaca mohon periksa data set';
            return response()->json($response);
        }
    }

    public function uploadFile(Request $request, $oke)
    {
        $result = '';
        $file = $request->file($oke);
        $name = $file->getClientOriginalName();

        $extension = explode('.', $name);
        $extension = strtolower(end($extension));

        $key = rand() . '-' . $oke;
        $tmp_file_name = "{$key}.{$extension}";
        $tmp_file_path = "assets/data_set";
        $file->move($tmp_file_path, $tmp_file_name);
        $result = $tmp_file_name;
        return $result;
    }
}