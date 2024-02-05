<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $table = 'bitcoinx_countries';
	protected $hidden = [
        'created_at', 'updated_at',
    ];
	 public function userprofileCountry() {
        return $this->belongsTo('App\Userprofile', 'country', 'id');
    }
     
}
