<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBdItemsPropuestasListTable extends Migration
{
    /**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::create('space_proposal', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('discount')->nullable();
            $table->string('subsidized_price')->nullable();
            $table->string('subsidized_description')->nullable();

            $table->timestamps();

            $table->integer('proposal_id');
            $table->foreign('proposal_id')->references('id_propuesta_LI')->on('propuestas_LIST');

            $table->integer('space_id');
            $table->foreign('space_id')->references('id_espacio_LI')->on('espacios_ofrecidos_LIST');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('space_proposal');
    }
}
