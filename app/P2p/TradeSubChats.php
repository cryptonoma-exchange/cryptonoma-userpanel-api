<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class TradeSubChats extends Model
{
    protected $table = 'p2ptrade_sub_chats';

    public function fromUserDetails() {
        return $this->belongsTo('App\User', 'uid', 'id');
    }
    public function toUserDetails() {
        return $this->belongsTo('App\User', 'to_uid', 'id');
    }
}