<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class Supportchat extends Model
{
    protected $fillable = [
    	'ticketid', 'message', 'userimg', 'reply', 'adminimg', 'user_status',  'admin_status'
    ];
    
    public function userDetails() {
        return $this->belongsTo('App\User', 'uid', 'id');
    }
}
