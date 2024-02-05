<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    
	protected $table = 'bitcoinx_commissions';
    protected $fillable = [
        'source','withdraw'
    ];

    public static function index()
    {
    	$commission = Commission::get();
    	return $commission;
    }
    public static function coinList()
    {
        $coins = Commission::get();
        $data =array();
        if(count($coins) > 0){
            foreach ($coins as $key => $coin) {
                $data[$key]['coinsymbol']   =  $coin->source;
                $data[$key]['coinname']     =  $coin->coinname;
                $data[$key]['cointype']     =  $coin->type;
                $data[$key]['image']        =  config('app.site_url').'/userpanel/images/color/'.$coin->image;
            }
        }
        return $data;
    }
    public static function coindetails($coin)
    {
        $commission = Commission::where('source', $coin)->first();
        return $commission;
    }

    public static function calculateAmountCommission($coin,$type,$amount=''){
        $commission = Commission::where('source', $coin)->first();
        if($type == 'buy'){
            $commission = ncDiv($commission->buy_trade, 100, 8);
        }elseif($type == 'sell'){
            $commission = ncDiv($commission->sell_trade, 100, 8);
        }elseif($type == 'withdraw'){            
            $commission = ncDiv($commission->withdraw, 100, 8);
        }else{
            return "invalid type check buy,sell,withdraw!";
        }
        if($amount ==''){
            $fee = $commission;
        }else{
            $fee = ncMul($amount, $commission,8);
        }
        return $fee;
    }

    public static function getKESLivePrice(){
        $kes = Commission::where("source","KES")->first();
        return $kes->usd_live_price;
    }
     
}
