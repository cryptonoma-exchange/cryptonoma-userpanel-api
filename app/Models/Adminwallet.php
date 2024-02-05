<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adminwallet extends Model
{
    protected $table = 'bitcoinx_adminwallet';
    protected $guarded = [];
    public static function admincreditAmount($currency, $amount, $commission,$type)
    {
        $adminbalnce = Adminwallet::where([['currency', '=',$currency]])->first();
        if($adminbalnce) {
            $total = ncAdd($amount, $adminbalnce->balance, 8);
            $adminbalnce->balance = $total;
            $adminbalnce->commission = $total;
            $adminbalnce->instant_type = $type;
            $adminbalnce->updated_at = date('Y-m-d H:i:s',time());
            $adminbalnce->save();
            return $adminbalnce;
        } else {        	
            Adminwallet::insert(['currency' => $currency, 'balance' => $amount, 'commission' => $amount, 'instant_type' => $type, 'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())]);
        }
    }

    public static function AdminWalletSave($GetDetail = null, $Updatedata)
    {
        $ActualValue = 0;
        if (!empty($GetDetail)) {
            if (isset($Updatedata['volumein'])) {
                if ($Updatedata['volumein'] > 0) {
                    $GetDetail->balance = ncAdd($GetDetail->balance, $Updatedata['volumein'], $Updatedata['decimal']);
                    $Updatedata['volumeout'] = 0;
                    $ActualValue = $Updatedata['volumein'];
                }
            } else if (isset($Updatedata['volumeout'])) {           
                if ($Updatedata['volumeout'] > 0) {
                    $GetDetail->balance = ncSub($GetDetail->balance, $Updatedata['volumeout'], $Updatedata['decimal']);
                     $Updatedata['volumein'] = 0;
                    $ActualValue = $Updatedata['volumeout'];
                }
            }  
             if(!isset($Updatedata['volumein']))
             $Updatedata['volumein']=0;
             if(!isset($Updatedata['volumeout']))
             $Updatedata['volumeout']=0;

            if ($Updatedata['volumeout'] > 0 || $Updatedata['volumein'] > 0)  
            $GetDetail->save();      
            $Updatedata['balance'] = $GetDetail->balance;
        } else {
            $GetDetail=new Adminwallet();
            $Updatedata['volumeout']=0;
            $Updatedata['balance']=$Updatedata['volumein'];
            $GetDetail->balance = $Updatedata['volumein'];     
            $GetDetail->created_at = date('Y-m-d H:i:s', time());
            $GetDetail->updated_at = date('Y-m-d H:i:s', time());
            $GetDetail->currency = $Updatedata['currency'];
            $ActualValue = $Updatedata['volumein'];
            if(!isset($Updatedata['volumein']))
            $Updatedata['volumein']=0;
            if(!isset($Updatedata['volumeout']))
            $Updatedata['volumeout']=0;
            if ($Updatedata['volumeout'] > 0 || $Updatedata['volumein'] > 0)
            $GetDetail->save();
        }
        if ($Updatedata['volumeout'] > 0 || $Updatedata['volumein'] > 0)
        AdminTransactions::AdminWalletDetInsert($Updatedata);
        unset($Updatedata);
        return true;
    }

    public static function AdminWalletbalanceUpdate($Updatedata)
    {      
        $oWalletDet = Adminwallet::where([['currency', $Updatedata['currency']]])->lockForUpdate()
            ->first();
        if (isset($Updatedata['volumeout'])) {
            if (!empty($oWalletDet)) {
                if ($Updatedata['volumeout'] > 0) {               
                        if ($oWalletDet->balance < $Updatedata['volumeout']) {
                            return false;
                        }                   
                }
            } else {
                return false;
            }
        }      
        return Adminwallet::AdminWalletSave($oWalletDet, $Updatedata); 
    }



    public static function credit($uid,$refid,$refentry,$refentrysubtype,$currency,$volumein,$remark=""){
        $adminbalance = Adminwallet::where('currency', '=', $currency)->lockForUpdate()->first();
        if ($adminbalance) {
            $old_balance = $adminbalance->balance;
            $total_bal = ncAdd($volumein, $adminbalance->balance);
            $total_cmn = ncAdd($volumein, $adminbalance->commission);
            $balance = $total_bal;
            $adminbalance->update(['balance' => $total_bal, 'commission' => $total_cmn]);
        } else {
            $old_balance = 0;
            $balance = $volumein;
            Adminwallet::create(['currency' => $currency, 'balance' => $volumein, 'commission' => $volumein]);
        }
        $trans = new AdminTransactions();
        $trans->uid = $uid;
        $trans->refid = $refid;
        $trans->refentry = $refentry;
        $trans->refentrysubtype = $refentrysubtype;
        $trans->currency = $currency;
        $trans->volumein = $volumein;
        $trans->volumeout = 0;
        $trans->balance = $balance;
        $trans->old_balance = $old_balance;
        $trans->remark = $remark;
        $trans->created_at = date('Y-m-d H:i:s', time());
        $trans->updated_at = date('Y-m-d H:i:s', time());
        $trans->save();
    }


}
