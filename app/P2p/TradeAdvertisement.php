<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class TradeAdvertisement extends Model
{
    protected $table = 'p2ptrade_advertisement';
    
    public function tradeDetails() {
        return $this->belongsTo('App\P2p\Commission', 'trade_pair', 'id');
    }
    public function userDetails() {
        return $this->belongsTo('App\P2p\User', 'user_id', 'id');
    }
    public function feedbackDetails() {
        return $this->belongsTo('App\P2p\FeedBackPercentage', 'user_id', 'uid');
    }
}
