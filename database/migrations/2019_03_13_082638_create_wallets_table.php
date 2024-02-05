<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid');
            $table->foreign('uid')->references('id')->on('users');  
            $table->string('currency')->nullable();
            $table->text('mukavari')->nullable();
            $table->string('payment_id',100)->nullable();
            $table->double('balance')->default(0);
            $table->double('coin_mathippu')->default(0);
            $table->double('escrow_balance')->default(0);
            $table->double('site_balance')->default(0);
            $table->double('receive')->default(0);
            $table->double('spend')->default(0);
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
       Schema::dropIfExists('wallets');
    }
}
