<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

use App\Models\GeneralSettings;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpVerification;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;
      protected $table = 'bitcoinx_users'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','google2fa_secret','verifyToken','referal_id','parent_id','affiliate_id','account_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','google2fa_secret','profile_otp',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {

        // print_r($this->getJWTIdentifier());
        // exit;
        $data=[];
        $user = auth()->user();
        $user = User::where('id',$this->getJWTIdentifier())->first();    
        $kyc_enable  = GeneralSettings::where('key','kyc_enable')->value('status');
        $twofa_withdraw  = GeneralSettings::where('key','twofa_withdraw_enable')->value('status');


         
        // $data['app_finger_status'] = $user->app_finger_status;
        // $data['app_face_status'] = $user->app_face_status;

        $data['emailtwofa'] = 0;
        $data['googletwofa'] = 0;
   

        $twofa='';
        if($user->twofa == 'email_otp' && $user->twofa_status == 1) 
        {
            $twofa='email_otp';
        }else if ($user->twofa == 'google_otp' && $user->twofa_status == 1){
            $twofa='google_otp';
        } 


        $data = array(
            'name'            => $user->name,
            'email'           => $user->email,
            'twoauth'         => $twofa,
            'authverf'        => $user->google2fa_verify,
            'image'           => $user->profileimg,
            'kyc'             => $user->kyc_verify,
            'kyc_enable'      => $kyc_enable,
            'twofa_withdraw'  => $twofa_withdraw,
            'app_finger_status'=>$user->app_finger_status,
            'app_face_status'=>$user->app_face_status
        );
  
        return $data;
    }

    public function sendEmailOtp(){
        $rand = rand(100000, 999999);
        $this->profile_otp = $rand;
        $this->save();
        try {
            Mail::to($this->email)->send(new SendOtpVerification($this));
        } catch (\Throwable $th) {
        }
    }

    public function tfaEnabled(){
        if(!empty($this->twofa) && $this->twofa_status == 1){
            return true;
        }
        return false;
    }
}
