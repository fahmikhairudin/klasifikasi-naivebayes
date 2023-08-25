<?php

namespace App\Models;
use DB;
use Session;
use StopWords\StopWords;
use Amaccis\Stemmer\Stemmer;
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
        $text = str_split($text);
        $arr = [];
        foreach ($text as $key => $value) 
        {
            $algorithm = "indonesian";
			$word = $value;
			$stemmer = new Stemmer($algorithm);
			$stem = $stemmer->stemWord($word);
			array_push($arr, $stem);
        }

        return $arr;
    }
}