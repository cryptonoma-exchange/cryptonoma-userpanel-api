<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leverage extends Model
{
    protected $table = 'leverages'; 

    public static function getCommission($level){
    	$data = 0;
        $commission = Leverage::where([['value', '=', $level]])->value('commission');
        $data 	= ncDiv($commission,100);
        return $data;
    }
    public static function calculateLeverage($level,$amount){
    	$data = 0;
        $commission = Leverage::where([['value', '=', $level]])->value('commission');
        $percent 	= ncDiv($commission,100);
        $data 		= ncMul($amount,$percent);
        return $data;
    }

    public static function trueLeverage($level,$amount){
        $value = ncDiv(1,$level,8);
        $total = ncMul($value,$amount,8);
        return $total;
    }  
}
