<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class Buytrade extends Model
{
    protected $table = 'p2pbuytrades';

    public function buyUserDetails() {
        return $this->belongsTo('App\User', 'from_uid', 'id');
    }

    public function sellUserDetails() {
        return $this->belongsTo('App\User', 'to_uid', 'id');
    }

    public function comDetails() {
        return $this->belongsTo('App\P2p\Commission', 'pair', 'id');
    }
}
