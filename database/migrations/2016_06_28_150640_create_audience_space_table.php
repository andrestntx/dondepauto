<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudienceSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audience_space', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('audience_id');
            $table->foreign('audience_id')->references('id')->on('audiences');

            $table->integer('space_id');
            $table->foreign('space_id')->references('id_espacio_LI')->on('espacios_ofrecidos_LI');

            $table->unique(['audience_id', 'space_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('audience_space');
    }
}
