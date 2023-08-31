<?php

namespace App\Models;
use DB;
use Session;
use StopWords\StopWords;
use App\Models\TfIdf;
use Sastrawi\Stemmer\StemmerFactory;
class Pre
{
	public function execute($data,$trainId)
    {
        $result = [];
        $stemmerF = new StemmerFactory();
        $stemmer = $stemmerF->createStemmer();
        $steamArr = [];
        foreach ($data as $latihKey => $latihValue) 
        {
            $result[$latihKey]['id'] = $latihValue->id;
            $result[$latihKey]['kronologi'] = $latihValue->kronologi;
            $result[$latihKey]['label'] = $latihValue->label;
            $result[$latihKey]['preprocessing'] = $latihValue->preprocessing;
            if($latihValue->preprocessing == NULL)
            {
                //casefolding
                $text = strtolower($latihValue->kronologi);
                //filtering
                $stopWords = new StopWords('id');
                $stopWords->clean($text);
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
                $preprocessing = implode(',', array_unique($arr));
                DB::table('data_train')->where('id',$latihValue->id)->update(['preprocessing'=>$preprocessing]);
                $result[$latihKey]['preprocessing'] = $preprocessing;
            }
        }

        foreach ($data as $key => $value) 
        {
           $exp = explode(',', $value->preprocessing);
           foreach ($exp as $expKey => $expValue) 
           {
              array_push($steamArr, $expValue);
           }
        }

        $steamArr = array_unique($steamArr);
        $arrFinal = [];
        $hasil = [];
        foreach ($result as $resultKey => $resultValue) 
        {
            $text = explode(' ',$resultValue['kronologi']);
            $id = $resultValue['id'];
            $label = $resultValue['label'];
            $no = 0;
            //pencarian term
            $termTotal = 0;
            $freqTotal = 0;
            foreach ($steamArr as $key => $value) 
            {
                $arrFinal[$value][$label]['id'] = $id;
                $arrFinal[$value][$label]['freq'] = 0;
                $arrFinal[$value][$label]['df'] = 0;
                $arrFinal[$value][$label]['d_df'] = 5;
                $arrFinal[$value][$label]['log'] = log(5);
                $arrFinal[$value][$label]['prob'] = 0;
                foreach ($text as $textKey => $textValue) 
                {
                   $word = $textValue;
                   $stem = $stemmer->stem($word);
                   if($stem == $value)
                   {
                        $arrFinal[$value][$label]['freq']++;
                   }
                }

                if($arrFinal[$value][$label]['freq'] > 0)
                {
                    $arrFinal[$value][$label]['d_df'] = $arrFinal[$value][$label]['d_df']/$arrFinal[$value][$label]['freq'];
                    $arrFinal[$value][$label]['log'] = log($arrFinal[$value][$label]['d_df']);
                }
                $freqTotal += $arrFinal[$value][$label]['freq'];
                $arrFinal[$value][$label]['df'] = $freqTotal;
                $termTotal += $arrFinal[$value][$label]['d_df'];
                $totalBagi = $freqTotal + $termTotal;
                $arrFinal[$value][$label]['prob'] = ($arrFinal[$value][$label]['freq'] + 1) / $totalBagi;
            }
        }
        
        //tfidf 
        $tfidf = new TfIdf();
        $gas = $tfidf->insertTfidf($arrFinal,$steamArr,$trainId);
        $hasil = DB::table('data_tf_idf')->get();
        return $hasil;
    }
}