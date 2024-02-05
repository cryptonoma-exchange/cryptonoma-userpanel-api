<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawEmail;

class Fiattransactions extends Model
{
    protected $table = 'bitcoinx_fiat_transactions';


    public static function listView($uid,$coin,$type)
    {
    	$list = Fiattransactions::where(['uid' => $uid, 'currency' => $coin,'type'=>$type])->orderBy('id', 'desc')->paginate(15);     	
    	return $list;
    }
    public static function listViewall($uid,$coin,$type)
    {
    	$list = Fiattransactions::where(['uid' => $uid,'currency' => "KES",'type'=>$type])->orderBy('id', 'desc')->paginate(15);     	
    	return $list;
    }


    public static function createTransaction($InsertData = null)
    { 
        $Transact = new Fiattransactions();
        $Transact->uid = $InsertData['uid'];
        if(isset($Transact->txid))
            $Transact->txid = $InsertData['txid'];
        else
            $Transact->txid = TransactionString();

        if(isset($InsertData['txid'])){
            $Transact->txid = $InsertData['txid'];
        }
        $Transact->currency = $InsertData['currency'];
        if (isset($InsertData['account_name'])) 
            $Transact->account_name = $InsertData['account_name'];
        if (isset($InsertData['abanoadmin']))  
            $Transact->abanoadmin= $InsertData['abanoadmin'];
        if (isset($InsertData['account_no']))  
            $Transact->account_no= $InsertData['account_no'];

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
            $Transact->coutryregion = $BankData->countrydata;
        }
        $Transact->save();
        return $Transact->id;
    } 
}

