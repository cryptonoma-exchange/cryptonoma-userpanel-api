<?php

use Illuminate\Database\Seeder;

class TradepairsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.ETH/BTC, BTC/USDT, ETH/USDT
     *
     * @return void
     */
    public function run()
    {
      DB::table('tradepairs')->insert(
      [
          'coinone'           => 'ETH',
          'cointwo'           => 'BTC',
          'min_buy_price'     => 0.001,
          'min_buy_amount'    => 0.0001,
          'min_sell_price'    => 0.01,
          'min_sell_amount'   => 0.0001,
          'active'            => 1,
          'orderlist'         => 1,
          'type'              => 1,
          'created_at'        => date("Y-m-d H:i:s"),
          'updated_at'        => date("Y-m-d H:i:s"),     
      ]);

      DB::table('tradepairs')->insert(
      [
          'coinone'           => 'LTC',
          'cointwo'           => 'BTC',
          'min_buy_price'     => 0.0001,
          'min_buy_amount'    => 0.0001,
          'min_sell_price'    => 0.0001,
          'min_sell_amount'   => 0.0001,
          'active'            => 1,
          'orderlist'         => 2,
          'type'              => 0,
          'created_at'        => date("Y-m-d H:i:s"),
          'updated_at'        => date("Y-m-d H:i:s"),     
      ]);

      DB::table('tradepairs')->insert(
      [
          'coinone'           => 'USDT',
          'cointwo'           => 'BTC',
          'min_buy_price'     => 0.0001,
          'min_buy_amount'    => 0.0001,
          'min_sell_price'    => 0.0001,
          'min_sell_amount'   => 0.0001,
          'active'            => 1,
          'orderlist'         => 3,
          'type'              => 0,
          'created_at'        => date("Y-m-d H:i:s"),
          'updated_at'        => date("Y-m-d H:i:s"),     
      ]);
       DB::table('tradepairs')->insert(
      [
          'coinone'           => 'GUAP',
          'cointwo'           => 'BTC',
          'min_buy_price'     => 0.0001,
          'min_buy_amount'    => 0.0001,
          'min_sell_price'    => 0.0001,
          'min_sell_amount'   => 0.0001,
          'active'            => 1,
          'orderlist'         => 3,
          'type'              => 0,
          'created_at'        => date("Y-m-d H:i:s"),
          'updated_at'        => date("Y-m-d H:i:s"),     
      ]);

        DB::table('tradepairs')->insert(
      [
          'coinone'           => 'XRP',
          'cointwo'           => 'BTC',
          'min_buy_price'     => 0.0001,
          'min_buy_amount'    => 0.0001,
          'min_sell_price'    => 0.0001,
          'min_sell_amount'   => 0.0001,
          'active'            => 1,
          'orderlist'         => 3,
          'type'              => 0,
          'created_at'        => date("Y-m-d H:i:s"),
          'updated_at'        => date("Y-m-d H:i:s"),     
      ]);

    }
}
