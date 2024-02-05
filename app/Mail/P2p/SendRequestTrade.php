<?php

namespace App\Mail\P2p;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\P2p\User;
use App\P2p\TradeAdvertisement;

class SendRequestTrade extends Mailable
{
    use Queueable, SerializesModels;

    protected $toname;
    protected $tradetypemail;
    protected $amount;
    protected $btc;
    protected $tradeid;
    protected $tktid;
    protected $type;
    protected $msg;

    public function __construct($toname,$tradetypemail,$amount,$btc,$tradeid,$tktid,$type=null,$msg=null)
    {

        $this->toname = $toname;
        $this->tradetypemail = $tradetypemail;
        $this->amount = $amount;
        $this->btc = $btc;
        $this->tradeid = $tradeid;
        $this->tktid = $tktid;
        if(!empty($type)){
            $this->type = $type;
        }else{
            $this->type = 'test';
        }
        if(!empty($msg)){
            $this->msg = $msg;
        }else{
            $this->msg = 'test';
        }
    }
    public function build()
    {
        $user = User::where('id', \Auth::id())->first();
        $tradedetails=TradeAdvertisement::where('id',$this->tradeid)->first();
        return $this->markdown('email.p2p.sendRequestMail')
        ->with([
            'username' => $user->name,
            'userEmail' => $user->email,
            'toname' => $this->toname,
            'tradetypemail' => $this->tradetypemail,                       
            'amount' => $this->amount,                       
            'btc' => $this->btc,                       
            'tktid' => $this->tktid,                       
            'msg' => $this->msg,                       
            'type' => $this->type,                       
            'currency' => $tradedetails->currency,  
            'trade_price' => $tradedetails->trade_price,  
            'source' => $tradedetails->tradeDetails['source'],  
            'signature' => '<p>Regards</p>'
        ])->subject('Got a new offer for your '.strtoupper($this->tradetypemail)." advertisement from ".$user->name);
    }
}