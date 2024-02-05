<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IeoListing extends Model
{
	 protected $table = "bitcoinx_ieo_listings";
    protected $connection ="mysql";
    public static function createListing($request){
    	$list 				= new IeoListing;
    	$list->name 		= $request->name;
    	$list->email 		= $request->email;
    	$list->servicetype 	= $request->servicetype;
    	$list->website 		= $request->websites;
    	$list->coin 		= $request->coin;
    	$list->comments 	= $request->comments;
    	$list->status 		= 0;
    	$list->created_at 	= date('Y-m-d H:i:s',time());
		$list->updated_at 	= date('Y-m-d H:i:s',time());
		$list->save();
		return $list;
    }
}
