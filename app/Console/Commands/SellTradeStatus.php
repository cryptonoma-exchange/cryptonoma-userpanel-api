<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\TradeData;
use App\User;
use App\Models\Tradepair;
use App\Models\Selltrade;
use App\Models\Wallet;
use App\Models\Adminwallet;
use App\Models\AdminTransactions;
use App\Models\OverallTransaction;
use App\Libraries\BinanceClass;

class SellTradeStatus extends Command
{
    use TradeData;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:selltrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update liquidity Sell trade histroy status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $liq_pairs = Tradepair::where('type',1)->get();
        if(count($liq_pairs) > 0){
            foreach ($liq_pairs as $pair) {
                $selltrades = Selltrade::where([ ['status', '=', 0],['pair', '=', $pair->id]])->get();
                if(count($selltrades) > 0){
                    foreach ($selltrades as $selltrade) {
                        $api = new BinanceClass;
                        $orderid = $selltrade->order_id;
                        $liqu = $pair->coinone.$pair->cointwo;
                        $orderstatus = $api->order_status($liqu, $orderid);

                        if($orderstatus['status'] == 'NEW'){
                          $status ='0';
                          $order_status = $orderstatus['status'];
                        }
                        elseif($orderstatus['status'] == 'canceled'){
                          $status ='100';
                          $order_status = $orderstatus['status'];
                           $update = array('status' => 100,'status_text' => $order_status,'updated_at' => date('Y-m-d H:i:s',time()));
                            Selltrade::where('id', $selltrade->id)->update($update);
                        }
                        elseif($orderstatus['status'] == 'CANCELED'){
                          $status ='100';
                          $order_status = $orderstatus['status'];
                           $update = array('status' => 100,'status_text' => $order_status,'updated_at' => date('Y-m-d H:i:s',time()));
                            Selltrade::where('id', $selltrade->id)->update($update);
                        }
                        elseif($orderstatus['status'] == "FILLED"){
                          $status ='1';
                          $order_status = $orderstatus['status'];
                          $adminbalanceupdate = $this->adminBalanceUpdate($pair->cointwo, $selltrade->fees,'sell');
                            AdminTransactions::CreateTransaction($selltrade->uid, 'sell', $pair->cointwo,0,$selltrade->price,$selltrade->volume,$selltrade->value,$selltrade->fees,$selltrade->commission,'Sell trade complete');                    
                            //update trade complete
                            $update = array('remaining' => 0,'status_text' => $order_status,'status' => 1,'updated_at' => date('Y-m-d H:i:s',time()));
                            
                            Selltrade::where('id', $selltrade->id)->update($update);
                            $remain_price = bcadd(sprintf('%.10f', $selltrade->volume), sprintf('%.10f', $selltrade->fees), 8);
                            
                            
                            $this->debitAmount($selltrade->uid, $pair->coinone, $remain_price); 
                            $remark ="Sell trade complete bittrex pair $pair->coinone / $pair->cointwo";
							$creditamt = bcmul(sprintf('%.10f', $orderstatus['price']), sprintf('%.10f', $selltrade->volume), 8);
                            $this->creditAmount($selltrade->uid, $pair->cointwo, $creditamt,$remark,'web liquidity',$selltrade->id);
                        }

                    }
                }
            }
        }
        $this->info('Sell trade updated to All Users');
    }
    /**
        * [debitAmount description]
        * @param  [int] $uid      [user ID]
        * @param  [string] $currency [Currency Name]
        * @param  [float] $price    [price value]
        * @return void
    */
    public function debitAmount($uid, $currency, $price) {
        
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        if ($userbalance) {
            $total = bcsub(sprintf('%.10f', $userbalance->escrow_balance), sprintf('%.10f', $price), 8);
            $update_wallet = Wallet::where('uid', $uid)->where('currency', $currency)
            ->update(['escrow_balance' => $total]);
            } else {
            Wallet::insert(['uid' => $uid, 'currency' => $currency, 'escrow_balance' => $price, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        }
        
    }
    
    /**
        * [creditAmount description]
        * @param  [int] $uid      [user ID]
        * @param  [string] $currency [Currency Name]
        * @param  [float] $price    [price value]
        * @return void
    */
    public function creditAmount($uid, $currency, $price,$remark=null,$actionfrom=null,$actionid=null) {
        
        $userbalance = Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->first();
        if ($userbalance) {
            $oldbalance = $userbalance->balance;
            $total = bcadd(sprintf('%.10f', $price), sprintf('%.10f', $userbalance->balance), 8);
            Wallet::where([['uid', '=', $uid], ['currency', '=', $currency]])->update(['balance' => $total], ['updated_at' => date('Y-m-d H:i:s')]);
            $balance = $total;
        } else {
            $oldbalance = 0;
            $balance = $price;
            Wallet::insert(['uid' => $uid, 'currency' => $currency, 'balance' => $price, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        }        
        OverallTransaction::addTransaction($uid,$currency,'selltrade',$price,0,$balance,$oldbalance,$remark,$actionfrom,$actionid);
    }
    /**
        * [adminBalanceUpdate description]
        * @param  [string] $currency [Curreny name]
        * @param  [float] $price    [price value]
        * @return void
    */
    public function adminBalanceUpdate($currency, $price,$type=null) {
        $adminbalance = Adminwallet::where('currency', '=', $currency)->first();
        if ($adminbalance) {
            $total_bal = ncAdd($price, $adminbalance->balance, 8);
            $total_cmn = ncAdd($price, $adminbalance->commission, 8);
            $trade     = ncAdd($price, $adminbalance->trade, 8);
            if($type == 'buy'){
                $buytrade     = ncAdd($price, $adminbalance->buytrade, 8);
                $selltrade    = $adminbalance->selltrade;
            }else{
                $buytrade     = $adminbalance->buytrade;
                $selltrade    = ncAdd($price, $adminbalance->selltrade, 8);
            }
            Adminwallet::where('currency', '=', $currency)->update(['balance' => $total_bal, 'commission' => $total_cmn, 'trade'=>$trade, 'buytrade'=>$buytrade,'selltrade'=>$selltrade,'updated_at' => date('Y-m-d H:i:s')]);
        } else {
             if($type == 'buy'){
                $buytrade     = $price;
                $selltrade    = 0;
            }else{
                $buytrade     = 0;
                $selltrade    = $price;
            }
            Adminwallet::insert(['currency' => $currency, 'balance' => $price, 'commission' => $price, 'trade'=>$price, 'buytrade'=>$buytrade,'selltrade'=>$selltrade,'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())]);
        }

    }


}
