<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    
protected $table = 'subscriber';

       protected $fillable = [
        'email','ip_address'
    ];
     
}
