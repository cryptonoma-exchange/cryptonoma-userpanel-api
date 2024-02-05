<?php

namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
		protected $table = 'user_login'; 
		protected $fillable = ['user_id','login_ip','status','location']; 

		public static function attemptSave($data)
		{
			UserLogin::create($data);
			return true;
		}

		public static function attemptUpdate($data)
		{
			UserLogin::create($data);
			return true;
		}
}