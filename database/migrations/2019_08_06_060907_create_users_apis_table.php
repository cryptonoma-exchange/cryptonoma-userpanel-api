<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_apis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('public_key')->unique();
            $table->string('private_key')->unique();
            $table->boolean('live_trading')->nullable()->default(0);
            $table->boolean('withdrawal')->nullable()->default(0);
            $table->boolean('network')->nullable()->default(0);
            $table->longtext('description')->nullable();
            $table->string('ip_addres')->nullable();
            $table->boolean('active_status')->nullable()->default(1);
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
        Schema::dropIfExists('users_apis');
    }
}
