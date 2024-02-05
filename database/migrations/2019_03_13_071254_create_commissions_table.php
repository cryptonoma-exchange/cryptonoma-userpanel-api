<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('source')->nullable();
            $table->double('withdraw')->nullable();
            $table->double('buy_trade')->nullable();
            $table->double('sell_trade')->nullable();
            $table->enum('type', ['fiat','coin','token','stock']);
            $table->string('coinname')->nullable();
            $table->double('netfee')->nullable();
            $table->integer('point_value')->nullable();
            $table->double('min_deposit')->nullable();
            $table->double('min_withdraw')->nullable();
            $table->double('max_withdraw')->nullable();
            $table->text('url')->nullable();
            $table->string('contractaddress',190)->nullable();
            $table->text('abiarray')->nullable();
            $table->text('decimal')->nullable();
            $table->text('image')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('shown')->nullable();
            $table->boolean('is_tag')->nullable();
            $table->smallInteger('orderlist')->nullable();
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
        Schema::dropIfExists('commissions');

    }
}
