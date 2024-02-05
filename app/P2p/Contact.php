<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    
protected $table = 'contact';

       protected $fillable = [
        'name','email','subject','phone','message'
    ];
     
}
