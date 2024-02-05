<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  FiatTransaction extends Model
{
    protected $table = "bitcoinx_fiat_transactions";

    public static function listView($uid,$coin)
    {
    	$list = FiatTransaction::where(['uid' => $uid, 'currency' => $coin])->orderBy('id', 'desc')->paginate(15);     	
    	return $list;
    }
    public static function orderCancel($id,$uid)
    {
    	$deposit = FiatTransaction::where(['id' => $id,'uid' => $uid,'status'=> 0])->first();
    	if(is_object($deposit))
        {
        	$deposit->status = 3;
        	$deposit->save();   
        	return true;         
        }else{
            return false;  
        }
    }


    public static function createTransaction($InsertData = null)
    { 
        $Transact = new FiatTransaction();
        $Transact->uid = $InsertData['uid'];
        if(isset($Transact->txid))
            $Transact->txid = $InsertData['txid'];
        else
            $Transact->txid = TransactionString();
        $Transact->currency = $InsertData['currency'];

        $Transact->type = $InsertData['type'];
        $Transact->amount = $InsertData['amount'];
        $Transact->fee = $InsertData['fee'];
        $Transact->totalamount = $InsertData['totalamount'];
        $Transact->status = $InsertData['status'];
        $Transact->nirvaki_nilai = $InsertData['nirvaki_nilai'];
        if (isset($InsertData['proof'])) $Transact->proof = $InsertData['proof'];
        if (isset($InsertData['paymenttype'])) $Transact->paymenttype = $InsertData['paymenttype'];
        if(isset($InsertData['bank_id'])){
        $Transact->bank_id = $InsertData['bank_id'];
        $BankData = Bankuser::where(['id' => $InsertData['bank_id']])->first();
        $Transact->account_name = $BankData->account_name;
        $Transact->account_no = $BankData->account_no;
        $Transact->bank_name = $BankData->bank_name;
        $Transact->bank_branch = $BankData->bank_branch;
        $Transact->bank_address = $BankData->bank_address;
        $Transact->swift_code = $BankData->swift_code;
        $Transact->branch_code = $BankData->branch_code;
        }
        $Transact->created_at = date('Y-m-d H:i:s', time());
        $Transact->updated_at = date('Y-m-d H:i:s', time());

        $Transact->save();
        return $Transact->id;
    } 
}
