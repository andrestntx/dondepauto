<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('espacios_ofrecidos_LIST', function (Blueprint $table) {
            $table->string('agencia_impactos_LI')->nullable();
            $table->string('link_youtube_LI')->nullable();
            $table->integer('descuento_espacio_LI')->default(0);
            $table->enum('restringeSexo_LI', ['N', 'S'])->default('N');
            $table->enum('restringeReligion_LI', ['N', 'S'])->default('N');
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
            $table->dropColumn(['restringeSexo_LI', 'agencia_impactos_LI', 'link_youtube_LI', 'descuento_espacio_LI']);
        });
    }
}
