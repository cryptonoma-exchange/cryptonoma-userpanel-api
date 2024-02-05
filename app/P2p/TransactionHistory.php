<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    protected $table = 'p2ptransactions_history';

    public function buytradeDetails() {
        return $this->belongsTo('App\P2p\Buytrade','tradetableid','id');
    }

    public function selltradeDetails() {
        return $this->belongsTo('App\P2p\Selltrade','tradetableid','id');
    }

    public function fromUserDetails() {
        return $this->belongsTo('App\P2p\User','from_uid','id');
    }

    public function toUserDetails() {
        return $this->belongsTo('App\P2p\User','to_uid','id');
    }
}
