<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTransactionBtc extends Model
{
      protected $table = 'bitcoinx_user_transaction_btcs';
    protected $connection = 'mysql2';

    public static function addTransaction($uid,$type,$credit=null,$debit=null,$balance,$oldbalance=0,$remark=null,$actionfrom=null,$actionid){
        $tran = new UserTransactionBtc();
        $tran->uid 			= $uid;
        $tran->type 		= $type;
        $tran->credit 		= $credit;
        $tran->debit 		= $debit;
        $tran->balance 		= $balance;
        $tran->oldbalance 	= $oldbalance;
        $tran->remark 		= $remark;
        $tran->updatefrom 	= 'user';
        $tran->actionfrom	= $actionfrom;
        $tran->actionid	 	= $actionid;
        $tran->created_at	= date('Y-m-d H:i:s',time());
        $tran->updated_at	= date('Y-m-d H:i:s',time());
        $tran->save();        
        return $tran;
    }
}
