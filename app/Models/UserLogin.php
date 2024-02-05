<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
class UserLogin extends Model
{
    // protected $connection = 'mysql2';
	protected $table = 'bitcoinx_user_login'; 
	protected $fillable = ['user_id','login_ip','status','location','type']; 

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
	
	public static function isLogged($uid,$ip,$location,$type){
        $userLogin = UserLogin::where(['user_id' => $uid,'login_ip' =>$ip])->first();
        if(!$userLogin){
        	$userLogin = new UserLogin();
        	$userLogin->user_id = $uid;
        	$userLogin->login_ip = $ip;
            $userLogin->type = $type;
        	$userLogin->created_at = date('Y-m-d H:i:s',time());
        }
        $userLogin->location = $location;
        $userLogin->status = 1;
        $userLogin->type = $type;
        $userLogin->updated_at = date('Y-m-d H:i:s',time());
        $userLogin->save();
        //Update User Table
        $userupdate = User::where('id',$uid)->first();
        $userupdate->is_logged = 1;
        $userupdate->ipaddr = $ip;
        $userupdate->location = $location;
        $userupdate->save();
        return true;
    } 

    public static function islogout($uid,$ip1){
    	UserLogin::where(['user_id'=> $uid,'login_ip' => $ip1])->update(['status' => 0,'updated_at' => date('Y-m-d H:i:s')]);
    	$userupdate = User::where('id',$uid)->first();
        $userupdate->is_logged = 0;
        $userupdate->save();
    	return true;
    }
}