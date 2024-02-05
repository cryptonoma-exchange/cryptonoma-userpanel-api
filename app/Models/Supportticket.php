<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supportticket extends Model
{
    protected $table = 'bitcoinx_supporttickets';

    protected $fillable = [
    	'uid', 'ticket_id',
    ];

}
