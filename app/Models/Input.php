<?php

namespace App\Models;
use DB;
use Session;
use Shuchkin\SimpleXLSX;
use Illuminate\Http\Request;
use Carbon\Carbon;
class Input
{
	public function uploadDataSet($request)
    {
    	//Session::put('input_data_kronologi',[]);
    	//Session::put('input_data_jenis',[]);
        $response = [];
        $file = $this->uploadFile($request,'file');

        //insert database
        $fileId = DB::table('data_input_excel')->insertGetId([
            'file'=>$file,
            'created_at'=>Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
        ]);

        $xlsx =SimpleXLSX::parse(public_path('/assets/data_set/'.$file));
        $ff = $xlsx->rows();
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
                if(isset($result[0]['KRONOLOGI']) && isset($result[0]['NAMA']) && isset($result[0]['LABEL']) && isset($result[0]['ALAMAT']))
                {
                    $response['success'] = true;
                    $response['data'] = $fileId;
                    $response['text'] = [];
                    $response['message'] = 'Berhasil Membaca Data Set';
                    
                    foreach ($result as $key => $value) 
                    {
                        $response['text']['kronologi'][$key] = $value['KRONOLOGI'];
                        $response['text']['label'][$key] = strtolower(str_replace(' ', '_', $value['LABEL']));
                        $response['text']['nama'][$key] = $value['NAMA'];
                        $response['text']['alamat'][$key] = $value['ALAMAT'];
                    }
                    return $response;
                }else
                {
                    $response['success'] = false;
                    $response['data'] = '';
                    $response['text'] = [];
                    $response['message'] = 'Tidak dapat membaca data set';
                    return $response;
                }
            }else
            {
                $response['success'] = false;
                $response['data'] = '';
                $response['text'] = [];
                $response['message'] = 'Data kolom tidak terbaca mohon periksa data set';
                return $response;
            }
        }else{
            $response['success'] = false;
            $response['data'] = '';
            $response['text'] = [];
            $response['message'] = 'Data tidak terbaca mohon periksa data set';
            return $response;
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