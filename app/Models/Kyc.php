<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    protected $table = 'bitcoinx_kyc'; 
    protected $primaryKey = 'kyc_id';
    protected $guarded = [];
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function country() {
        return $this->belongsTo('App\Models\Country', 'country', 'id');
    }
}
