<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_number');
            $table->timestamps();

            $table->integer('publisher_id')->unique();
            $table->foreign('publisher_id')->references('id_us_LI')->on('us_reg_LIST');

            $table->integer('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bank_user');
    }
}
