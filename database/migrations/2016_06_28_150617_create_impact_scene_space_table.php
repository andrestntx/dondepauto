<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpactSceneSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impact_scene_space', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('impact_scene_id');
            $table->foreign('impact_scene_id')->references('id_tipo_lugar_LI')->on('tipos_lugares_ubicacion_espacios_LIST');

            $table->integer('space_id');
            $table->foreign('space_id')->references('id_espacio_LI')->on('espacios_ofrecidos_LI');

            $table->unique(['impact_scene_id', 'space_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('impact_scene_space');
    }
}
