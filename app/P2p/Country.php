<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	protected $table = 'countries';
    
	 public function userprofileCountry() {
        return $this->belongsTo('App\Userprofile', 'country', 'id');
    }
     
}
