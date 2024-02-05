<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coinwithdraw extends Model
{
	protected $table = 'bitcoinx_coin_withdraw';

    protected $fillable = [
     'uid', 'coin_name', 'sender','reciever','amount','transaction_id','remark','status'
    ];
    
    public static function listView($uid,$coin)
    {
    	$list = Coinwithdraw::where(['uid' => $uid, 'coin_name' => $coin])->orderBy('id', 'desc')->paginate(15);     	
    	return $list;
    }
    
    public static function createTransaction($uid,$coin,$fromaddress,$toaddress,$amount,$fee,$ramount,$status=0){
    	$Withdraw 					= new Coinwithdraw();
    	$Withdraw->uid 				= $uid;
    	$Withdraw->coin_name		= $coin;
    	$Withdraw->sender 			= $fromaddress;
    	$Withdraw->reciever 		= $toaddress;
    	$Withdraw->amount 			= $amount;
    	$Withdraw->request_amount 	= $ramount;
    	$Withdraw->admin_fee 		= $fee;
    	$Withdraw->transaction_id 	= TransactionString(15);
    	$Withdraw->status 			= $status;
        //$Withdraw->withdrawtype     = $withdrawtype;
        //$Withdraw->ipaddress        = $ip;
        //$Withdraw->location         = $location;
    	$Withdraw->created_at 		= date('Y-m-d H:i:s',time());
    	$Withdraw->updated_at 		= date('Y-m-d H:i:s',time());
    	$Withdraw->save();
    	return $Withdraw->id;
    }
    

}
