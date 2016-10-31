<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_space', function (Blueprint $table) {
            $table->increments('id');
            $table->double('discount')->default(0);
            $table->boolean('with_markup')->default(true);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('selected')->default(false);

            $table->timestamps();
            
            $table->integer('proposal_id');
            $table->foreign('proposal_id')->references('id_propuesta_LI')->on('propuestas_LIST');

            $table->integer('space_id');
            $table->foreign('space_id')->references('id_espacio_LI')->on('espacios_ofrecidos_LIST');

            $table->unique(['space_id', 'proposal_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proposal_space');
    }
}
