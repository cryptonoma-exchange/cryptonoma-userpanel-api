<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class Cryptotransaction extends Model
{
    protected $table = 'p2pcryptotransactions';

    public static function listView($uid,$coin)
    {
    	$list = Cryptotransaction::where(['uid' => $uid, 'currency' => $coin])->orderBy('id', 'desc')->paginate(10);     	
    	return $list;
    }

    public static function createTransaction($uid,$coin,$from,$to,$amount,$status,$type){
                $tran = new Cryptotransaction();
                $tran->uid = $uid;
                $tran->currency = $coin;
                $tran->txtype = $type;
                $tran->txid = self::TransactionString(15);
                $tran->from_addr = $from;
                $tran->to_addr = $to;
                $tran->amount = $amount;            
                $tran->status = $status;
                $tran->confirmation = 3;
                $tran->save();
                return $tran;

    }
    public function coinDetails()
    {
      return $this->belongsTo('App\Bankuser', 'bank_id');
    }


    public static function TransactionString($length = 15) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}
