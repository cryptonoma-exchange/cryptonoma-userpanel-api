<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOverallTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('overall_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('uid');
            $table->string('coin',10)->nullable();
            $table->enum('type',['buytrade','selltrade','trade','deposit','withdraw','affiliate']);            
            $table->double('credit')->nullable();
            $table->double('debit')->nullable();
            $table->double('balance')->nullable();
            $table->double('oldbalance')->default(0);
            $table->string('remark',150)->nullable();
            $table->enum('updatefrom',['user','admin'])->nullable();
            $table->string('actionfrom',150)->nullable();
            $table->string('actionid',150)->nullable();
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
        Schema::connection('mysql2')->dropIfExists('overall_transactions');
    }
}
