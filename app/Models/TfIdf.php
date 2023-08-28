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
							'df' => $data[$steamArrValue][$labelValue->nama]['df'],
							'd_df' => $data[$steamArrValue][$labelValue->nama]['d_df'],
							'idf' => $data[$steamArrValue][$labelValue->nama]['log'],
							'updated_at'=>Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
						]);
					}else
					{
						$getId = $check->id;
						$name = $labelValue->nama;
						$freq = $check->$name;
						$freq += $data[$steamArrValue][$labelValue->nama]['freq'];
						DB::table('data_tf_idf')->where('id',$getId)->update([
							''.$labelValue->nama.'' => $freq,
							'df' => $data[$steamArrValue][$labelValue->nama]['df'],
							'd_df' => $data[$steamArrValue][$labelValue->nama]['d_df'],
							'idf' => $data[$steamArrValue][$labelValue->nama]['log'],
							'updated_at'=>Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
						]);
						$no++;
					}
				}
			}
		}

		return $no;
	}
}