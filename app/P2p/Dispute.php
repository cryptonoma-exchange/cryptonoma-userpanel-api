<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $table = 'p2pdispute';

  public function tradeAdvDetails() {
        return $this->belongsTo('App\P2p\TradeAdvertisement', 'tradeid', 'id');
    }
}
