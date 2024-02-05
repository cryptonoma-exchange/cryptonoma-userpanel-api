<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class TradeChats extends Model
{
    protected $table = 'p2ptrade_chats';


    public function tradeAdvDetails() {
        return $this->belongsTo('App\P2p\TradeAdvertisement', 'tradeid', 'id');
    }

    public function fromUserDetails() {
        return $this->belongsTo('App\P2p\User', 'from_uid', 'id');
    }

    public function toUserDetails() {
        return $this->belongsTo('App\P2p\User', 'to_uid', 'id');
    }
}
