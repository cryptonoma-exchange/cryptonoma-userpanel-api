<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $table = 'p2pfeedback';

    public function userDetails() {
        return $this->belongsTo('App\User', 'to_uid', 'id');
    }
    
    public function fromuserDetails() {
        return $this->belongsTo('App\User', 'from_uid', 'id');
    }
}
