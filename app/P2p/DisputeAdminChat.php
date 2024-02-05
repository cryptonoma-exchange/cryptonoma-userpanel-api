<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class DisputeAdminChat extends Model
{
    protected $table = 'p2pdispute_admin_chat';
    //dispute_admin_chat
    
    public function fromUserDetails() {
        return $this->belongsTo('App\User', 'from_uid', 'id');
    }
    public function toUserDetails() {
        return $this->belongsTo('App\User', 'to_uid', 'id');
    }
}
