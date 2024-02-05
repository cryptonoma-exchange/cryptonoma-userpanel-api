<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subapicategory extends Model
{
    protected $table ='bitcoinx_sub_merchant_api';


    public static function index()
    {
        $forum = Subapicategory::get();

        return $forum;
    }

    public function apiDetails()
    {
      return $this->belongsTo('App\Apicategory', 'cat_id');
    }

  }
