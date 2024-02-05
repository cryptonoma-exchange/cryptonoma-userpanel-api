<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    
	protected $table = 'p2pcommissions';
    protected $fillable = [
        'source','withdraw'
    ];

    public static function index()
    {
    	$commission = Commission::get();
    	return $commission;
    }

    public static function coindetails($coin)
    {
        $commission = Commission::where('source', $coin)->first();
        return $commission;
    }

    public static function pairdetails($coin)
    {
        $commission = Commission::where('id', $coin)->first();
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
    public static function coinDecimal($coin){
        $commission = Commission::where('source', $coin)->value('point_value');
        return $commission;
    }
     
}
