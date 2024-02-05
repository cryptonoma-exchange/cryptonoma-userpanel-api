<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class Selltrade extends Model
{
    protected $table = 'p2pselltrades';

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
