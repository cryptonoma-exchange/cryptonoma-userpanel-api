<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apicategory extends Model
{
    protected $table ='bitcoinx_api_category';
    protected $fillable = ['id','category','created_at','updated_at',];


    public static function index()
    {
    	$forum = Apicategory::get();

    	return $forum;
    }



  }
