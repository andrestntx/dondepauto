<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('tel');
            $table->string('email')->unique();
            $table->enum('role', ['admin', 'director', 'adviser', 'advertiser', 'publisher']);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->integer('user_platform_id')->nullable();
            $table->foreign('user_platform_id')->references('id_us_LI')->on('us_reg_LIST');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
