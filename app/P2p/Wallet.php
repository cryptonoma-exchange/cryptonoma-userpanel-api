<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{   
    protected $connection = 'mysql';
    protected $table = 'p2pwallets';
    protected $fillable = ['uid', 'currency',	'balance',	'escrow_balance','created_at', 'updated_at' ];

    public static function getAddress($uid, $currency){
        $address = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->value('mukavari');
        return $address;
    }

    public static function checkAddress($address, $currency){        
       $check = Wallet::where([['mukavari', '=', $address], ['currency', '=', $currency]])->first();
        if ($check) {
            return true;
        }else{
            return false;
        }
    }

    public static function debitAmount($uid, $currency, $amount, $decimal)
    {
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        if($userbalance) {
            $total = ncSub($userbalance->balance, $amount, $decimal);
            if($total < 0)
                $total = 0;

            $site_balance = 0;
            if($userbalance->site_balance > 0)
            {
                $site_balance = ncSub($userbalance->site_balance,$amount, $decimal);
            }
            $userbalance->balance       = $total;
            $userbalance->site_balance  = $site_balance;
            $userbalance->updated_at    = date('Y-m-d H:i:s',time());
            $userbalance->save();
            return $userbalance;
        }else{
        	return false;
        }
        
    }

    public static function creditAmount($uid, $currency, $amount, $decimal)
    {
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=',$currency]])->first();
        if($userbalance) {
            $total                = ncAdd($amount, $userbalance->balance, $decimal);
            $site_balance         = ncAdd($amount, $userbalance->site_balance, $decimal);
            $userbalance->balance = $total;
            $userbalance->site_balance = $site_balance;
            $userbalance->updated_at   = date('Y-m-d H:i:s',time());
            $userbalance->save();
            return $userbalance;
        } else {        	
            Wallet::insert(['uid' => $uid, 'currency' => $currency, 'balance' => $amount, 'site_balance' => $amount, 'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())]);
        }
    }

    public static function checkEscrowbalance($uid, $currency){
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=',$currency]])->value('escrow_balance');        
        return $userbalance;
    }


    public static function escrowAdd($uid, $currency, $amount, $decimal){
            $update = Wallet::where(['uid'=>$uid,'currency'=>$currency])->update([
                    'balance' => DB::raw('balance - '.$amount),
                    'escrow_balance' => DB::raw('escrow_balance + '.$amount),
            ]);

            if($update)
                return true;
            else
                return false;

    }

    public static function escrowRemove($uid, $currency, $amount, $decimal){
            $update = Wallet::where(['uid'=>$uid,'currency'=>$currency])->update([                    
                    'escrow_balance' => DB::raw('escrow_balance - '.$amount),
            ]);
            if($update)
                return true;
            else
                return false;
    }

    public static function escrowCancel($uid, $currency, $amount, $decimal){
           $update = Wallet::where(['uid'=>$uid,'currency'=>$currency])->update([
                    'balance' => DB::raw('balance + '.$amount),
                    'escrow_balance' => DB::raw('escrow_balance - '.$amount),
            ]);

           if($update)
                return true;
            else
                return false;
    }


}
