<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class DisputeSubChat extends Model
{
    protected $table = 'p2pdispute_sub_chats';
    
    
    public function fromUserDetails() {
        return $this->belongsTo('App\User', 'from_uid', 'id');
    }

    public function toUserDetails() {
        return $this->belongsTo('App\User', 'to_uid', 'id');
    }
}
