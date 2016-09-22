<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalRepresentatitvesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_representatives', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('doc')->unique()->unsigned()->nullable();
            $table->string('email')->unique();
            
            $table->string('name');
            $table->string('phone');
            
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
        Schema::drop('legal_representatives');
    }
}
