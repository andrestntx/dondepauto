<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCopyIdSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('espacios_ofrecidos_LIST', function (Blueprint $table) {
            $table->integer('copy_id')->nullable();
            $table->foreign('copy_id')->references('id_espacio_LI')->on('espacios_ofrecidos_LIST');
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
            $table->dropIndex('espacios_ofrecidos_list_copy_id_foreign');
            $table->dropColumn('copy_id');
        });
    }
}
