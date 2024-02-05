<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Selltrade extends Model
{
	protected $guarded = [];
        protected $table = 'bitcoinx_selltrades';
    public function sellTradeuser() 
    {
        return $this->belongsTo('App\User', 'uid', 'id');
    }

    public static function createSelltrade($uid,$pair,$ordertype,$price='',$volume,$value,$fees,$commission,$remaining,$status,$leverage,$leverage_fee,$leverage_commission,$spend,$is_auto=0){
    	$trade = new Selltrade;
		$trade->uid = $uid;
		$trade->pair = $pair;
		$trade->order_type = $ordertype;
		$trade->price = $price;
		$trade->volume = $volume;
		$trade->value = $value;
		$trade->fees = $fees;
		$trade->commission = $commission;
		$trade->remaining = $remaining;
		$trade->status = $status;
		$trade->leverage = $leverage;
		$trade->leverage_fee = $leverage_fee;
		$trade->leverage_commission = $leverage_commission;
        $trade->spend = $spend;
		$trade->is_auto = $is_auto;
		$trade->created_at = date('Y-m-d H:i:s',time());
		$trade->updated_at = date('Y-m-d H:i:s',time());
		$trade->save();
		return $trade;
    }
    public static function completeSelltrade($id){
    	$data = Selltrade::where('id', $id)->first();
        if($data){
        	$data->status = 1;
        	$data->updated_at = date('Y-m-d H:i:s',time());
        	$data->save();
        	return $data;
        }else{
            return false;
        }
    }
    public static function cancelSelltrade($id){
    	$data = Selltrade::where('id', $id)->first();
        if($data){
        	$data->status = 100;
        	$data->updated_at = date('Y-m-d H:i:s',time());
        	$data->save();
        	return $data;
        }else{
            return false;
        }
    }
    public static function checkStatus($id){
        $data = Selltrade::where('id', $id)->value('status');
        if($data == 0){
            return true;
        }else{
            return false;
        }
    }
}
