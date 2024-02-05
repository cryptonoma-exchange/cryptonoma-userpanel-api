<?php
namespace App\P2p;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','google2fa_secret','is_logged','ipaddr','device','location','trade_count','feedback_per','profile_otp','user_refferal','website_refferal','refferal_through','refferal_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function userprofileDetails()
    {
        return $this->hasOne('App\Userprofile\P2p', 'user_id', 'id');
    }


     public function userWalletDetails()
    {
        return $this->hasOne('App\UserWallet\P2p', 'user_id', 'id');
    }
    

    public function userFeedBackDetails()
    {
        return $this->hasOne('App\FeedBackPercentage\P2p', 'uid', 'id');
    }
}
