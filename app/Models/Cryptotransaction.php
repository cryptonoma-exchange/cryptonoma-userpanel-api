<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cryptotransaction extends Model
{
    protected $table = 'bitcoinx_cryptotransactions';

    public static function listView($uid,$coin)
    {
    	$list = Cryptotransaction::where(['uid' => $uid, 'currency' => $coin])->orderBy('id', 'desc')->paginate(10);     	
    	return $list;
    }

    public static function createTransaction($fuid, $tuid, $coin,$network="", $txid, $from, $to, $amount, $confirm = 0, $time, $status = 0, $nirvaki_nilai = 0, $TxType = '', $adminfee = 0,$TotalAmount=0,$remark="",$memo="")
    { 
        $tran = new Cryptotransaction();  
        if($TxType == 'deposit'){
            $tran->uid = $tuid;
            $tran->fuid = $fuid;
            $tran->tuid = $tuid;
        }else{
            $tran->uid = $fuid;
            $tran->fuid = $fuid;
            $tran->tuid = $tuid;
            $tran->adminfee = $adminfee;
            $tran->network = $network;
        } 
        $tran->currency = $coin;

        $tran->txtype = $TxType;
        $tran->txid = $txid;
        $tran->from_addr = $from;
        $tran->to_addr = $to;
        $tran->amount = $amount;
        $tran->memo = $memo;
        $tran->totalamount = $TotalAmount;
        $tran->status = $status;
        $tran->nirvaki_nilai = $nirvaki_nilai;
        $tran->created_at = $time;
        $tran->confirmation = $confirm;
        $tran->remark = $remark;
        $tran->updated_at = date('Y-m-d H:i:s', time());
        $tran->save();
        return $tran;
    }
    
    public function coinDetails()
    {
      return $this->belongsTo('App\Bankuser', 'bank_id');
    }
}
