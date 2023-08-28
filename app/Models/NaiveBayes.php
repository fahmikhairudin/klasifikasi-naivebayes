<?php

namespace App\Models;
use DB;
use Session;
use StopWords\StopWords;
use Sastrawi\Stemmer\StemmerFactory;
class NaiveBayes
{
	public function nbc($label,$text)
	{
		$stemmerF = new StemmerFactory();
        $stemmer = $stemmerF->createStemmer();
		//casfolding
		$text = strtolower($text);
		//filtering
        $stopWords = new StopWords('id');
        $stopWords->clean($text);
        //dd($text);
        //steaming
        $text = explode(' ', $text);
        $arr = [];
        foreach ($text as $key => $value) 
        {
           $word = $value;
           $stem = $stemmer->stem($word);
           array_push($arr, $stem);
        }
        //remove null
        foreach ($arr as $key => $value) 
        {
          if(is_null($value))
           {
             unset($arr[$key]);
           }
         }
         $arr = array_unique($arr);
         foreach ($arr as $key => $value) 
         {
         	$dataKata = DB::table('data_tf_idf')->where('kata',$value)->first();
         	if(!$dataKata)
         	{
         		unset($arr[$key]);
         	}
         }
         $preprocessing = implode(',', $arr);

         //probabilitas data uji
         $probKal = [];
         $labelData = DB::table('data_label_term')->get();
         //dd($arr);
         foreach ($labelData as $labelDataKey => $labelDataValue)
         {
         	$arrTemp = [];
         	
         	$nama = $labelDataValue->nama;
	         $probName = 'prob_'.$nama;
         	//if($dataKata)
         	//{
         		foreach ($arr as $key => $value)
	         	{
	         		$dataKata = DB::table('data_tf_idf')->where('kata',$value)->first();
	         		if($dataKata)
	         		{
		         		$prob = $dataKata->$probName;
	         			array_push($arrTemp, floatval($prob));
	         			$probKal[$nama]['kata'][$value] = floatval($prob);
	         		}
	         	}
	         	$hasil = array_product($arrTemp) * $labelDataValue->nilai_p;
	         	$hasil =  $this->decimal_notation($hasil);
	         	$hasil = str_replace('.', '', $hasil);
	         	$hasil = str_replace('0', '', $hasil);
	         	$probKal[$nama]['result_p'] = intval($hasil);
         	//}
         }
         //dd($probKal);
         $final = [];
         $finalName = [];
         $noN = -1;
         foreach ($probKal as $key => $value) 
         {
         	$noN++;
         	$final[$key] = $value['result_p'];
         	//$finalName[$noN] = $key;
         }
         arsort($final);
         $maxs = array_keys($final, max($final));
         //dd();
         $oke = [];
         $oke['nbc'] = $maxs[0];
         $oke['data'] = $final;
         $oke['preprocessing'] = $preprocessing;
         //dd($oke);
         return $oke;
	}

	function decimal_notation($float) {
        $parts = explode('E', $float);

        if(count($parts) === 2){
            $exp = abs(end($parts)) + strlen($parts[0]);
            $decimal = number_format($float, $exp);
            return rtrim($decimal, '.0');
        }
        else{
            return $float;
        }
    }
}