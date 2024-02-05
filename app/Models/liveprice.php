<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class liveprice extends Model
{
  
  protected $table ="bitcoinx_live_price";

  protected $guarded = [];

  public static function getLivePrice($base,$symbol){
    $price = liveprice::where('base', $base)->where("currency",$symbol)->first();
    return $price ? $price->price : false;
  }

  public static function kesToUsdt($amount,$priceInUsdt = null){
    if(empty($priceInUsdt)){
      $price = liveprice::where('base', "USDT")->where("currency","KES")->first();
      $priceInUsdt = $price->price;
    }
    return ncDiv($amount,$priceInUsdt);
  }

  public static function usdtToKes($amount,$priceInKes = null){
    if(empty($priceInUsdt)){
      $price = liveprice::where('base', "USDT")->where("currency","KES")->first();
      $priceInKes = ncDiv(1,$price->price);
    }
    return ncDiv($amount,$priceInKes);
  }
}
