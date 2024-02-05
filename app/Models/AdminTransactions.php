<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminTransactions extends Model
{
    protected $table = 'bitcoinx_admin_transactions';

    public static function CreateTransaction($uid, $type, $currency,$amount,$price,$quantity,$value,$fee,$commission,$remark)
    {
        $data = new AdminTransactions();
        $data->uid = $uid;
        $data->type = $type;
        $data->currency = $currency;
        $data->amount = $amount;
        $data->price = $price;
        $data->quantity = $quantity;
        $data->value = $value;
        $data->fee = $fee;
        $data->commission = $commission;
        $data->remark = $remark;
        $data->created_at = date('Y-m-d H:i:s',time());
        $data->updated_at = date('Y-m-d H:i:s',time());
        $data->save();
        return $data;
    }

    public static function AdminWalletDetInsert($Updatedata)
    {
        $trans = new AdminTransactions();
        $trans->uid = $Updatedata['uid'];
        $trans->refid = $Updatedata['refid'];
        $trans->refentry = $Updatedata['refentry'];
        $trans->refentrysubtype = $Updatedata['refentrysubtype'];
        $trans->currency = $Updatedata['currency'];
        $trans->volumein = $Updatedata['volumein'];
        $trans->volumeout = $Updatedata['volumeout'];
        $trans->balance = $Updatedata['balance'];
        if(isset($Updatedata['remarks']))
        $trans->remarks = $Updatedata['remarks'];
        $trans->created_at = date('Y-m-d H:i:s', time());
        $trans->docdate_at = date('Y-m-d H:i:s', time());
        $trans->updated_at = date('Y-m-d H:i:s', time());
        $trans->save();
        unset($Updatedata);
        return true;
    } 

}