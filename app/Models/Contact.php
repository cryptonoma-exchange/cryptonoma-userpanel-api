<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    
protected $table = 'bitcoinx_contact';

       protected $fillable = [
        'name','email','subject','phone','message'
    ];
       
}
       