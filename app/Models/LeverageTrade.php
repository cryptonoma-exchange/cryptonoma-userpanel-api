<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Buytrade;
use App\Models\Selltrade;
class LeverageTrade extends Model
{
    protected $table = 'leverage_trades';

    public static function createLeverge($uid, $currency,$amount,$tid,$type){
        $data 			= new LeverageTrade;
        $data->uid 		= $uid;
        $data->currency = $currency;
        $data->amount 	= $amount;
        $data->trade_id = $tid;
        $data->type 	= $type;
        $data->status 	= 0;
        $data->created_at = date('Y-m-d H:i:s',time());
		$data->updated_at = date('Y-m-d H:i:s',time());
        $data->save();
        return $data;
    }

    public static function cancelLeverge($uid, $currency){
        $data = LeverageTrade::where([['uid', '=', $uid], ['currency', '=', $currency],['status', '=', 0]])->get();
        if(count($data) > 0){
        	foreach ($data as $trade) {
        		if($trade->type == 'buy'){
        			Buytrade::completeBuytrade($trade->trade_id);
        		}else{
        			Selltrade::completeSelltrade($trade->trade_id);
        		}
        	}
	        LeverageTrade::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['status' => 1, 'updated_at' => date('Y-m-d H:i:s',time())]);
	    }
        return $data;
    } 

    public static function getDetails($uid, $currency){
        $data = LeverageTrade::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        return $data;
    } 
}
