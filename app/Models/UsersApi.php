<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Crypt;

class UsersApi extends Authenticatable
{
    protected $table ="bitcoinx_user_apis";
    use Notifiable;

    protected $guard ="userapi";

     protected $fillable = [
        'user_id', 'public_key', 'private_key'
    ];

    public static function create($uid,$pub,$pvt,$live_trading=0,$withdrawal=0,$network=0,$desc='',$ipaddress=''){    	
    	$data = new UsersApi();
    	$data->user_id 		= $uid;
    	$data->public_key 	= $pub;
    	$data->private_key 	= Crypt::encrypt($pvt);
        $data->live_trading = $live_trading;
        $data->withdrawal   = $withdrawal;
        $data->network      = $network;
        $data->description  = $desc;
        $data->ip_addres    = $ipaddress;
    	$data->created_at   = date('Y-m-d H:i:s',time());
    	$data->updated_at   = date('Y-m-d H:i:s',time());
    	$data->save();
    	return $data;
    }

    public static function Update_key($id,$uid,$live_trading=0,$withdrawal=0,$network=0,$desc,$ipaddress){      
        $data = UsersApi::where(['id'=> $id,'user_id' => $uid])->first();
        if($data){
            $data->live_trading   = $live_trading;
            $data->withdrawal  = $withdrawal;
            $data->network  = $network;
            $data->description  = $desc;
            $data->ip_addres  = $ipaddress;
            $data->created_at = date('Y-m-d H:i:s',time());
            $data->updated_at = date('Y-m-d H:i:s',time());
            $data->save();
        }else{
           $data = 'Invalid User'; 
        }
        return $data;
    }
	
	public function apidetails() {
        return $this->belongsTo('App\Models\UsersApiSetting', 'id', 'api_id');
    }
}
