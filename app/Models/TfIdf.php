<?php

namespace App\Models;
use DB;
use Session;
use Carbon\Carbon;
class TfIdf
{
	public function insertTfidf($data,$steamArr)
	{
		$no = 0;
		$label = DB::table('data_label_term')->get();
		foreach ($steamArr as $steamArrKey => $steamArrValue) 
		{
			foreach ($label as $labelKey => $labelValue) 
			{
				//dd($data[$steamArrValue][$labelValue->nama]);
				if(isset($data[$steamArrValue][$labelValue->nama]))
				{
					$id = $data[$steamArrValue][$labelValue->nama]['id'];
					$check = DB::table('data_tf_idf')->where('kata',$steamArrValue)->first();
					if(!$check)
					{
						$no++;
						$getId = DB::table('data_tf_idf')->insertGetId([
								//'data_train_id'=>$id,
								'kata'=>$steamArrValue,
								'created_at'=>Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
							]);

						DB::table('data_tf_idf')->where('id',$getId)->update([
							''.$labelValue->nama.'' => $data[$steamArrValue][$labelValue->nama]['freq'],
							'updated_at'=>Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
						]);
					}else
					{
						$getId = $check->id;
						// $name = $labelValue->nama;
						// $freq = $check->$name;
						$freq = $data[$steamArrValue][$labelValue->nama]['freq'];
						DB::table('data_tf_idf')->where('id',$getId)->update([
							''.$labelValue->nama.'' => $freq,
							'updated_at'=>Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
						]);
						$no++;
					}
				}
			}
		}

		//bersihkan kata tidak memeiliki term
		DB::table('data_tf_idf')->where('seksual','0')->where('pelecehan','0')->where('kekerasan_anak','0')->where('kdrt','0')->where('penipuan','0')->delete();
		//update df, d_df, idf
		$data = DB::table('data_tf_idf')->get();
		foreach ($data as $key => $value) 
		{	
			$df = 0;
			foreach ($label as $labelKey => $labelValue)
			{
				$nama = $labelValue->nama;
				$jml = $value->$nama;
				$df += $jml;
			}
			$d_df = 5;
			if($df > 0)
			{
				$d_df = 5 / $df;
			}
			
			$idf = log($d_df);
			DB::table('data_tf_idf')->where('id',$value->id)->update([
				'df'=>abs($df),
				'd_df'=>abs($d_df),
				'idf'=>abs($idf)
			]);
		}
		//update total term and 
		$totalDf = 0;
		foreach ($label as $labelKey => $labelValue) 
		{
			$nama = $labelValue->nama;
			$term = DB::table('data_tf_idf')->sum(''.$nama.'');
			$totalDf += $term;
			DB::table('data_label_term')->where('id',$labelValue->id)->update([
				'term'=>$term
			]);
		}
		//update total df
		DB::table('total_df')->where('id',1)->update([
			'total'=> $totalDf
		]);

		//update prob
		foreach ($data as $key => $value) 
		{
			//$hasil = 0;
			foreach ($label as $labelKey => $labelValue) 
			{
				$nama = $labelValue->nama;
				$freq = intval($value->$nama) + 1;
				$bagi = $labelValue->term + $totalDf;
				$hasil = $freq / $totalDf;
				DB::table('data_tf_idf')->where('id',$value->id)->update([
					'prob_'.$nama.''=>abs($hasil)
				]);
			}
		}

		return $no;
	}
}