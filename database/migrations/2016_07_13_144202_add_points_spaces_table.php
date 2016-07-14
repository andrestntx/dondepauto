<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointsSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('espacios_ofrecidos_LIST', function (Blueprint $table) {
            $table->integer('puntaje_LI')->default(0);
            $table->boolean('espacio_privados_LI')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('espacios_ofrecidos_LIST', function (Blueprint $table) {
            $table->dropColumn(['puntaje_LI', 'espacio_privados_LI']);
        });
    }
}
