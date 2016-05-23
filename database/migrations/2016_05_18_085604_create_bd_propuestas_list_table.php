<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBdPropuestasListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('observations')->nullable();

            $table->string('contact_name');
            $table->string('contact_role');

            $table->timestamps();
            $table->timestamp('sent_on')->nullable();

            $table->integer('advertiser_id');
            $table->foreign('advertiser_id')->references('id_us_LI')->on('us_reg_LIST');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proposals');
    }
}
