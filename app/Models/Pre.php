<?php

namespace App\Models;
use DB;
use Session;
use StopWords\StopWords;
use App\Models\Stemming;
class Pre
{
	public function execute($text)
    {
    	//casefolding
        $text = strtolower($text);
        //filtering
        $stopWords = new StopWords('id');
        $stopWords->clean($text);
        //steaming
        $text = explode(' ', $text);
        $arr = [];
        foreach ($text as $key => $value) 
        {
			$word = $value;
			$stemmer = new Stemming();
			$stem = $stemmer->stemming($word);
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
        $arrFinal = [];
        $no = 0;
        //pencarian term
        foreach ($arr as $key => $value) 
        {
            $arrFinal[$value] = 0;
            foreach ($text as $textKey => $textValue) 
            {
               if($textValue == $value)
               {
                    $arrFinal[$value]++;
               }
            }
        }
        $result = [];
        $result['term'] = $arrFinal;
        $result['filter'] = implode(',', $arr);
        return $result;
    }
}