<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('admin_bank_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coin',15)->nullable();
            $table->string('account_name',190)->nullable();
            $table->string('account_number',190)->nullable();
            $table->string('swift_code',190)->nullable();
            $table->string('iban',190)->nullable();
            $table->text('bank_name')->nullable();
            $table->text('bank_address')->nullable();
            $table->text('account')->nullable();
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
        Schema::dropIfExists('admin_bank_details');

    }
}
