<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelltradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selltrades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid');
            $table->foreign('uid')->references('id')->on('users');
            $table->string('ouid',50)->nullable();
            $table->string('order_id',50)->nullable();
            $table->integer('pair')->nullable();
            $table->integer('order_type')->nullable();
            $table->double('price')->nullable();
            $table->double('volume')->nullable();
            $table->double('value')->nullable();
            $table->double('fees')->nullable();
            $table->double('commission')->nullable();
            $table->double('remaining')->nullable();
            $table->double('stoplimit')->nullable();
            $table->integer('status')->default(0);
            $table->string('status_text',10)->nullable();
            $table->string('balance',20)->nullable();
            $table->integer('leverage')->default(1);
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
        Schema::dropIfExists('selltrades');
    }
}
