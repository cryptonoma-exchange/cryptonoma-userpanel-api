<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('uid');
            $table->enum('type', ['deposit', 'withdraw','buy','sell']);
            $table->string('currency',8)->nullable();
            $table->double('amount')->nullable();
            $table->double('price')->nullable();
            $table->double('quantity')->nullable();
            $table->double('value')->nullable();
            $table->double('fee')->nullable();
            $table->double('commission')->nullable();
            $table->string('remark',50)->nullable();
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
        Schema::dropIfExists('admin_transactions');
    }
}
