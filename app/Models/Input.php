<?php

namespace App\Models;
use DB;
use Session;
use Shuchkin\SimpleXLSX;
use Illuminate\Http\Request;
class Input
{
	public function uploadDataSet($request)
    {
    	Session::put('input_data_kronologi',[]);
    	Session::put('input_data_jenis',[]);
        $response = [];
        $file = $this->uploadFile($request,'data_set');
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
                if(isset($result[0]['KRONOLOGI']) && isset($result[0]['JENIS KEKERASAN']))
                {
                    $response['success'] = true;
                    $response['data'] = '';
                    $response['text'] = [];
                    $response['message'] = 'Berhasil Membaca Data Set';
                    
                    foreach ($result as $key => $value) 
                    {
                        if($key < $total)
                        {
                            $response['data'] .= $value['KRONOLOGI']."\xA";
                        }
                        $response['data'] .= $value['KRONOLOGI'];
                        $response['text']['kronologi'][$key] = $value['KRONOLOGI'];
                        $response['text']['jenis'][$key] = $value['JENIS KEKERASAN'];
                        $response['text']['steaming'][$key] = [];
                    }
                    return $response;
                }else
                {
                    $response['success'] = false;
                    $response['data'] = '';
                    $response['text'] = [];
                    $response['message'] = 'Data kolom KRONOLOGI atau JENIS KEKERASAN tidak terbaca mohon periksa data set';
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