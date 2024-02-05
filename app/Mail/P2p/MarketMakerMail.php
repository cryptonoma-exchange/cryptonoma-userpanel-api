<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\MarketMaker;
use App\User;

class MarketMakerMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
          $user = User::where('id', \Auth::id())->first();
        return $this->markdown('email.marketmakermail')
                    ->with([
                        'username' => $user->name,
                        'userEmail' => $user->email,
                        'amount' => $this->id,
                        'currency' => 'BTC',                       
                        'ipaddr' => 0,                       
                        'signature' => '<p>Regards</p>Naija Crypto Trade Team'
                    ]);

    }
}
