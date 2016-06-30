<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitySpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_space', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('city_id');
            $table->foreign('city_id')->references('id_ciudad_LI')->on('ciudades_LIST');

            $table->integer('space_id');
            $table->foreign('space_id')->references('id_espacio_LI')->on('espacios_ofrecidos_LI');

            $table->unique(['city_id', 'space_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city_space');
    }
}
