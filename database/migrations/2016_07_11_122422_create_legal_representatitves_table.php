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

            $table->integer('doc')->unique()->unsigned();
            $table->string('email')->unique();
            
            $table->string('name');
            $table->string('phone');

            $table->integer('publisher_id')->unique();
            $table->foreign('publisher_id')->references('id_us_LI')->on('us_reg_LIST');
            
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
