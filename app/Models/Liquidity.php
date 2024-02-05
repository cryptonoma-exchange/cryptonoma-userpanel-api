<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liquidity extends Model
{

    protected $connection = 'mysql';
    protected $table = 'bitcoinx_liquiditys';
}
