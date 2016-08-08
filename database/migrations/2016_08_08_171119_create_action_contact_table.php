<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->date('action_at');
            $table->timestamps();

            $table->integer('action_id');
            $table->foreign('action_id')->references('id')->on('actions');

            $table->integer('contact_id');
            $table->foreign('contact_id')->references('id')->on('contacts');

            $table->unique(['action_id', 'contact_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('action_contact');
    }
}
