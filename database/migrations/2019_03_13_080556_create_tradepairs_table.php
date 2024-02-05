<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('tradepairs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coinone')->nullable();
            $table->string('cointwo')->nullable();
            $table->double('min_buy_price')->nullable();
            $table->double('min_buy_amount')->nullable();
            $table->double('min_sell_price')->nullable();
            $table->double('min_sell_amount')->nullable();
            $table->integer('active')->nullable();
            $table->integer('orderlist')->nullable();
            $table->integer('type')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tradepairs');
    }
}
