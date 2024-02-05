<?php
namespace App\P2p;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    protected $table = 'p2pvaravuselavu';
       
    public static function listView($uid,$pair)
    {
        $list = Statement::where(['user_id' => $uid, 'pair' => $pair])->orderBy('time', 'desc')->paginate(5);        
        return $list;
    }

    public static function coindetails($coin)
    {
        $commission = Commission::where('source', $coin)->first();
        return $commission;
    }

    public static function typesname($types)
    {
        $array = array('1'=>'Deposit External','2'=>'Deposit Internal','3'=>'Deposit Commission','4'=>'Withdraw','5'=>'Withdraw Internal','6'=>'Withdraw Commission');
        return $array[$types];
    }

    public static function user_trans($uid,$pair,$amount,$selavu,$varavu,$trans_no,$type,$reference,$memo,$time)
    {   
        if($amount != 0)
        {
              $confirm   = 0;              
              $userTransaction                   = new Statement;
              $userTransaction->user_id       = $uid;
              $userTransaction->pair          = $pair;
              $userTransaction->type          = $type;
              $userTransaction->trans_no      = $trans_no; 
              $userTransaction->reference     = $reference;                            
              $userTransaction->amount        = $amount;              
              $userTransaction->selavu        = $selavu;              
              $userTransaction->varavu        = $varavu;              
              $userTransaction->memo          = $memo;              
              $userTransaction->time          = $time;
              $userTransaction->save();
              return "Balance updated!";
        }
    } 


    
    

}
