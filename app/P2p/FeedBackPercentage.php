<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class FeedBackPercentage extends Model
{
    protected $table = 'p2pfeedback_percentage';

    public function userDetails() {
        return $this->belongsTo('App\User', 'uid', 'id');
    }
}
