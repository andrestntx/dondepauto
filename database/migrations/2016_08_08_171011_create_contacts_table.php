<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['call', 'chat', 'email', 'meet'])->default('call');
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->integer('user_id');
            $table->foreign('user_id')->references('id_us_LI')->on('us_reg_LIST');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contacts');
    }
}
