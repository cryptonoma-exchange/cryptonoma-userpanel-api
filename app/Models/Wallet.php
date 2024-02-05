<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'bitcoinx_wallets';
    protected $fillable = ['uid', 'currency', 'balance','site_balance', 'escrow_balance', 'created_at', 'updated_at'];

    public static function getAddress($uid, $currency)
    {
        $address = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->value('mukavari');
        return $address;
    }

    public static function WalletSave($GetDetail = null, $Updatedata)
    {
        $ActualValue = 0;
        if (is_object($GetDetail)) {
            if (isset($Updatedata['volumein'])) {              
                if ($Updatedata['volumein'] > 0) {               
                    $GetDetail->balance = ncAdd($GetDetail->balance, $Updatedata['volumein']);
                    $GetDetail->site_balance = ncAdd($GetDetail->site_balance, $Updatedata['volumein']);
                    $Updatedata['volumeout'] = 0;
                    $ActualValue = $Updatedata['volumein'];
                }
            } else if (isset($Updatedata['volumeout'])) {
                if ($Updatedata['volumeout'] > 0) {
                    $GetDetail->balance = ncSub($GetDetail->balance, $Updatedata['volumeout']);
                    if($GetDetail->balance < 0){
                        throw new \Exception("Error Processing Request", 1);
                    }
                    $GetDetail->site_balance = ncSub($GetDetail->site_balance, $Updatedata['volumeout']);
                    $Updatedata['volumein'] = 0;
                    $ActualValue = $Updatedata['volumeout'];
                }
            }
            if(!isset($Updatedata['volumein']))
            $Updatedata['volumein']=0;
            if(!isset($Updatedata['volumeout']))
            $Updatedata['volumeout']=0;

            if($Updatedata['volumeout'] > 0 || $Updatedata['volumein'] > 0)
            $GetDetail->save();
            $Updatedata['uid'] = $GetDetail->uid;
            $Updatedata['balance'] = $GetDetail->balance;
        } elseif(isset($Updatedata['volumein'])) {
            $GetDetail=new Wallet();
            $Updatedata['volumeout']=0;
            $Updatedata['balance']=$Updatedata['volumein'];
            $GetDetail->balance = $Updatedata['volumein'];
            $GetDetail->site_balance = $Updatedata['volumein'];
            $GetDetail->uid = $Updatedata['uid'];
            $GetDetail->created_at = date('Y-m-d H:i:s', time());
            $GetDetail->updated_at = date('Y-m-d H:i:s', time());
            $GetDetail->currency = $Updatedata['currency'];
            $ActualValue = $Updatedata['volumein'];
            if(!isset($Updatedata['volumein']))
            $Updatedata['volumein']=0;
            if(!isset($Updatedata['volumeout']))
            $Updatedata['volumeout']=0;
            if($Updatedata['volumeout'] > 0 || $Updatedata['volumein'] > 0)
            $GetDetail->save();
        } else {
            throw new \Exception("Error Processing Request", 1);
        }
        $Updatedata['actualvalue'] = ncSub($ActualValue, $Updatedata['fee']);
        if($Updatedata['volumeout'] > 0 || $Updatedata['volumein'] > 0)
        Walletdet::WalletDetInsert($Updatedata);
        unset($Updatedata);
        return true;
    }

    public static function WalletbalanceUpdate($Updatedata)
    {
      
        $oWalletDet = Wallet::where([
            ['uid', '=', $Updatedata['uid']], 
            ['currency', $Updatedata['currency']]
        ])
        ->lockForUpdate()
        ->first(); 
        if (isset($Updatedata['volumeout'])) {
            if (!empty($oWalletDet)) {
                if ($Updatedata['volumeout'] > 0) {               
                    if ($oWalletDet->balance < $Updatedata['volumeout']) {
                        throw new \Exception("Error Processing Request", 1);
                    }                   
                }
            } else {
                return false;
            }
        }
        Wallet::WalletSave($oWalletDet, $Updatedata);
        return true;
    }









    public static function WalletEcrowSave($GetDetail = null, $Updatedata)
    {
        if(!isset($Updatedata['isescrowin']))
        $Updatedata['isescrowin'] == false;
        $ActualValue = 0;
        if (is_object($GetDetail)) {        
           
            if (isset($Updatedata['volumein'])) {              
                if ($Updatedata['volumein'] > 0) {
               
                    $GetDetail->balance = ncAdd($GetDetail->balance, $Updatedata['volumein'], $Updatedata['decimal']);                  
                    if(isset($Updatedata['istradecancel']) ){
                        $GetDetail->escrow_balance = ncSub($GetDetail->escrow_balance, $Updatedata['volumein'], $Updatedata['decimal']);
                    } else{
                        $GetDetail->site_balance = ncAdd($GetDetail->site_balance, $Updatedata['volumein'], $Updatedata['decimal']);
                    }
                    $Updatedata['volumeout'] = 0;
                    $ActualValue = $Updatedata['volumein'];
                }   
            } else if (isset($Updatedata['volumeout'])) {
                if ($Updatedata['volumeout'] > 0) {
                 
                    if ($Updatedata['isescrowin'] == true) {
                        $GetDetail->balance = ncSub($GetDetail->balance, $Updatedata['volumeout'], $Updatedata['decimal']);
                        $GetDetail->escrow_balance = ncAdd($GetDetail->escrow_balance, $Updatedata['volumeout'], $Updatedata['decimal']);
                    } else {
                        $GetDetail->escrow_balance = ncSub($GetDetail->escrow_balance, $Updatedata['volumeout'], $Updatedata['decimal']);
                        $GetDetail->site_balance = ncSub($GetDetail->site_balance, $Updatedata['volumeout'], $Updatedata['decimal']);
                    }

                    $Updatedata['volumein'] = 0;
                    $ActualValue = $Updatedata['volumeout'];
                }
            }
            if(!isset($Updatedata['volumein']))
            $Updatedata['volumein']=0;
            if(!isset($Updatedata['volumeout']))
            $Updatedata['volumeout']=0;

            if($Updatedata['volumeout'] > 0 || $Updatedata['volumein'] > 0)  
            $GetDetail->save();
            $Updatedata['uid'] = $GetDetail->uid;
            $Updatedata['balance'] = $GetDetail->balance;
        } else {
            $GetDetail=new Wallet();
            $Updatedata['volumeout']=0;
            $Updatedata['balance']=$Updatedata['volumein'];
            $GetDetail->balance = $Updatedata['volumein'];
            $GetDetail->site_balance = $Updatedata['volumein'];
            $GetDetail->uid = $Updatedata['uid'];
            $GetDetail->created_at = date('Y-m-d H:i:s', time());
            $GetDetail->updated_at = date('Y-m-d H:i:s', time());
            $GetDetail->currency = $Updatedata['currency'];
            $ActualValue = $Updatedata['volumein'];
            if(!isset($Updatedata['volumein']))
            $Updatedata['volumein']=0;
            if(!isset($Updatedata['volumeout']))
            $Updatedata['volumeout']=0;
            if($Updatedata['volumeout'] > 0 || $Updatedata['volumein'] > 0)            
            $GetDetail->save();
        }    
        $Updatedata['actualvalue'] = ncSub($ActualValue, $Updatedata['fee'], $Updatedata['decimal']);        

        if (!($Updatedata['isescrowin'] == false &&  $Updatedata['volumeout'] > 0) && ($Updatedata['volumeout'] > 0 || $Updatedata['volumein'] > 0)  )
            Walletdet::WalletDetInsert($Updatedata);
        unset($Updatedata);
        return true;
    }
  

    public static function WalletEscrowbalanceUpdate($Updatedata)
    {
        if(!isset($Updatedata['isescrowin']))
        $Updatedata['isescrowin'] = false;
        $oWalletDet = Wallet::where([['uid', '=', $Updatedata['uid']], ['currency', $Updatedata['currency']]])->lockForUpdate()
            ->first();
        if (isset($Updatedata['volumeout'])) {
            if (!empty($oWalletDet)) {
                if ($Updatedata['volumeout'] > 0) {
                    if ($Updatedata['isescrowin'] == true) {
                        if (($oWalletDet->balance < $Updatedata['volumeout'])) {
                            return false;
                        }
                    } else {
                        if ($oWalletDet->escrow_balance < $Updatedata['volumeout']) {
                            return false;
                        }
                    }
                }
            } else {
                return false;
            }
        }
        Wallet::WalletEcrowSave($oWalletDet, $Updatedata);
        return true;
    }











    public static function debitAmount($uid, $currency, $amount, $decimal, $type = null, $remark = null, $insertid)
    {
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        if ($userbalance) {
            $oldbalance = $userbalance->balance;
            $total = ncSub($userbalance->balance, $amount, $decimal);
            $site_balance = 0;
            if ($userbalance->site_balance > 0) {
                $site_balance = ncSub($userbalance->site_balance, $amount, $decimal);
            }
            $userbalance->balance = $total;
            $userbalance->site_balance = $site_balance;
            $userbalance->updated_at = date('Y-m-d H:i:s', time());
            $userbalance->save();
            self::AllcoinUpdateBalanceTrack($uid, $currency, 0, $amount, $total, $oldbalance, $type, $remark, $insertid);
            return $userbalance;
        } else {
            return false;
        }
    }
    public static function creditAmount($uid, $currency, $amount, $decimal, $type = null, $remark = null, $insertid)
    {

         $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();

    
        if ($userbalance) {
            $oldbalance = $userbalance->balance;
            $total = ncAdd($amount, $userbalance->balance, $decimal);

            $walletbalance = $total;
            $site_balance = ncAdd($amount, $userbalance->site_balance, $decimal);
            $userbalance->balance = $total;
            $userbalance->site_balance = $site_balance;
            $userbalance->updated_at = date('Y-m-d H:i:s', time());
            $userbalance->save();
        } else {
            $oldbalance = 0;
            $walletbalance = $amount;
            Wallet::insert(['uid' => $uid, 'currency' => $currency, 'balance' => $amount, 'site_balance' => $amount, 'created_at' => date('Y-m-d H:i:s', time()), 'updated_at' => date('Y-m-d H:i:s', time())]);
        }
        self::AllcoinUpdateBalanceTrack($uid, $currency, $amount, 0, $walletbalance, $oldbalance, $type, $remark, $insertid);
    }

    public static function AllcoinUpdateBalanceTrack($uid, $currency, $creditamount = 0, $debitamount = 0, $walletbalance = 0, $oldbalance = null, $tradetype = null, $remark = null, $insertid)
    {

        if ($creditamount > 0 || $debitamount > 0) {
            $Models = '\App\Models\UserTransaction' . $currency;
            $Models::AddTransaction($uid, $tradetype, $creditamount, $debitamount, $walletbalance, $oldbalance, $remark, 'web', $insertid);
        }
        return true;
    }

    public static function checkEscrowbalance($uid, $currency)
    {
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->value('escrow_balance');
        return $userbalance;
    }









    
}
