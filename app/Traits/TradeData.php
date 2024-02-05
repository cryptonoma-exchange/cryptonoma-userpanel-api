<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use codenixsv\Bittrex\BittrexManager;
use Auth;
use App\User;
use App\Models\Wallet;
use App\Models\Cryptotransaction;
use App\Models\Completedtrade;
use App\Models\Buytrade;
use App\Models\Selltrade;
use App\Models\Tradepair;
use App\Libraries\BinanceClass;
use App\Models\Fiattransactions;
use App\Models\Kyc_limit;
use App\Models\Kyc;


trait TradeData
{
  public function tradeBuy($pairid,$limit=10){
     $buytrades = Buytrade::select('price',DB::raw('SUM(remaining) as remaining'),DB::raw('group_concat(created_at) as created_at'))
      ->where(['order_type' => 1, 'pair' => $pairid,'status' => 0])        
      ->groupBy('price')
      ->orderBy('price', 'desc')
      ->limit($limit)->get();
      return $buytrades;
  }
  public function tradeSell($pairid,$limit=10){
       $selltrades = Selltrade::select('price', DB::raw('SUM(remaining) as remaining'),DB::raw('group_concat(created_at) as created_at'))
      ->where(['order_type' => 1, 'pair' => $pairid,'status' => 0])
      ->orderBy('price', 'desc')
      ->groupBy('price')
      ->limit($limit)->get();
      return $selltrades;
  }
  public function tradeComplete($pairid,$limit=10){
      $completedtrade = Completedtrade::where(['pair' => $pairid])->orderBy('id', 'desc')->limit($limit)->get();
      return $completedtrade;
  }
  //Binance Liquidity
  
  public function liquidityGetOrder($pairid,$order_id){
   $api = new BinanceClass;
    $pair = $this->marketpair($pairid);
    if($pair){            
      $details = $api->order_status($pair,$order_id);      
    }else{
      return 'Invalid pair id';
    }
    return $details;    
  }

  public function liquidityOrderBook($pairid){
    $api = new BinanceClass;
    $buytrades = array();
    $pair = $this->marketpair($pairid);
    if($pair){
      $market = $api->market_depth($pair);
      if(isset($market)){
        $buytrades = $market;
      }else{
        $buytrades = $market;                
      }        
    }else{
      return 'Invalid pair id';
    }
    return $buytrades;
  }

  public function LiquidityMarketHistory($pairid){
    $api = new BinanceClass;
    $buytrades = array();
    $pair = $this->marketpair($pairid);
    if($pair){            
      $completedtrade = $api->market_history($pair);           
    }else{
      return 'Invalid pair id';
    }
    return $completedtrade;
  }

  public function liquidityBuyLimitTrade($pairid,$price,$volume){
    $api = new BinanceClass;
    $pair = $this->marketpair($pairid);
    if($pair){            
      $details = $api->place_limit_buyorder($pair,$volume,$price);       
    }else{
      return 'Invalid pair id';
    }
    return $details;
  }

  public function liquiditySellLimitTrade($pairid,$price,$volume){
    $api = new BinanceClass;
    $pair = $this->marketpair($pairid);
    if($pair){            
      $details = $api->place_limit_sellorder($pair,$volume,$price);       
    }else{
      return 'Invalid pair id';
    }
    return $details;
  }

  public function marketpair($pairid){
    $pair = Tradepair::where(['id' => $pairid,'type' => (1 || 2) ])->first();
    if($pair){
      $coinone = $pair->coinone_binance;
      $cointwo = $pair->cointwo_binance;
      $market = $coinone.$cointwo;
      return $market;
    }else{
      return false;
    }
  }
  public function getChartData($pairid,$tickInterval='hour'){
      $client = $this->bittrexlogin();
      $buytrades = array();
      $pair = $this->marketpair($pairid);
      if($pair){
        //$url = "https://global.bittrex.com/Api/v2.0/pub/market/GetTicks?1563366144&tickInterval=hour&marketName=$pair";
        $url = "https://bittrex.com/Api/v2.0/pub/market/GetTicks?marketName=$pair&tickInterval=$tickInterval&_=1500915289433";             
         $details = json_decode($this->crulBittrex($url));
         if($details){
            $chat = $details->result;
         }else{
            $chat ="";
         }

      }else{
        return 'Invalid pair id';
      }
      return $chat;    
    }

	public function cancelOrder($pairid,$uuid){
		$api = new BinanceClass;
		$pair = $this->marketpair($pairid);
		if($pair){            
		  $details = $api->cancel_order($pair,$uuid);      
		}else{
		  return 'Invalid pair id';
		}
		return $details;    
	}
	public function crulBittrex($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $headers = array();
        $headers[] = "Accept: application/json, text/plain";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (curl_errno($ch)) {
            echo $result = 'Error:' . curl_error($ch);
        } else {
            $result = curl_exec($ch);
        }
        curl_close($ch);
        return $result;
    }

  //Get the last 24 hour summary of all active exchanges for a market
  public function getMarketSummary($pairid){
    $api = new BinanceClass;
    $buytrades = array();
    $pair = $this->marketpair($pairid);
    // if($pair){     
    //   $result =  $api->hr_ticker_price($pair);
    //   //dd($result);
    //   $data['Last']     = display_format($result['lastPrice']);
    //   $data['Low']      = display_format($result['lowPrice']);
    //   $data['High']     = display_format($result['highPrice']);
    //   $data['Volume']   = display_format($result['volume']);
    //   $data['Exchange'] = $result['priceChangePercent'];
    // }else{
      $data = $this->TradePrice($pairid);
   // }
    return $data;    
  }

  public function hrExchange($current,$yesterday){
    if($yesterday > 0){
      $exchangerate = ncSub($current, $yesterday, 8);
      $exchanger =  ncDiv($exchangerate, $yesterday, 8);     
      $exchange =  ncMul($exchanger, 100, 2);     
    }else{
      $exchange = display_format(0,2);
    }
    return $exchange;
  } 


  public function TradePrice($pairid){
    $yesterday = date('Y-m-d H:i:s', strtotime("-1 days"));
    $PrevDay = 0;
    $last = Completedtrade::where('pair',$pairid)->orderBy('id', 'desc')->value('price');
    $min = Completedtrade::where('pair',$pairid)->where('created_at', '>=', $yesterday)->min('price');
    $max = Completedtrade::where('pair',$pairid)->where('created_at', '>=', $yesterday)->max('price');
    $volume = Completedtrade::where('pair',$pairid)->where('created_at', '>=', $yesterday)->sum('volume');
    $PrevDay =  Completedtrade::where('pair',$pairid)->where('created_at', '<=', $yesterday)->orderBy('id', 'desc')->value('price');
    if(!$last){
      $last = 0;
    }
    if(!$min){           
      $min = 0;
    }
    if(!$max){
      $max = 0;
    }
    if(!$volume){
      $volume = 0;
    }
    $exchange = $this->hrExchange($last,$PrevDay);

    $data['Last']     = display_format($last);
    $data['Low']      = display_format($min);
    $data['High']     = display_format($max);
    $data['Volume']   = display_format($volume);
    $data['Exchange'] = $exchange;
    return $data;
  }
    public function Total_amt_fiat_deposit_withdraw($uid,$currentMonth){


          $Fiatamount = Fiattransactions::where(['uid' => $uid ,'status' =>1])->whereRaw('MONTH(updated_at) = ?',[$currentMonth])->sum('amount');

          $Fiatamount1 = Fiattransactions::where(['uid' => $uid ,'status' =>0])->whereRaw('MONTH(updated_at) = ?',[$currentMonth])->sum('amount');

          $amt = $Fiatamount + $Fiatamount1;

          return $amt;

  }


   public function Total_amt_crypto_deposit_withdraw($uid,$currentMonth){

        $coinamount = Cryptotransaction::where(['uid' => $uid ,'status' =>1])->whereRaw('MONTH(updated_at) = ?',[$currentMonth])->sum('amount');

        $coinamount1 = Cryptotransaction::where(['uid' => $uid ,'status' =>0])->whereRaw('MONTH(updated_at) = ?',[$currentMonth])->sum('amount');

        $amt = $coinamount +$coinamount1;

          return $amt;

  }
    public function coin_withdraw_control($uid,$type)
  {
              $Kycstatus = Kyc::where('uid',$uid)->latest()->first();


              if($type == 'fiat')
              {
                    if($Kycstatus->income_status == 1)
                        {
                             return Kyc_limit::where('type','intermediate')->value('fiat_limit');
                             
                        }
                        elseif($Kycstatus->status == 1)
                        {
                             return Kyc_limit::where('type','basic')->value('fiat_limit');
                        }
              }
              else{

                  if($Kycstatus->income_status == 1)
                  {
                    
                      return Kyc_limit::where('type','intermediate')->value('crypto_limit');

                  }
                  elseif($Kycstatus->status == 1)
                  {
                      
                      return Kyc_limit::where('type','basic')->value('crypto_limit');
                  }
              }
  }
    public function Kycstatus($uid){
   
    $kyc = Kyc::where('uid',$uid)->latest()->first();                    
    return $kyc;
  }



}