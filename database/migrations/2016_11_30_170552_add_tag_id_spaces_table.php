<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTagIdSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('espacios_ofrecidos_LIST', function (Blueprint $table) {
            $table->integer('tag_id')->nullable();
            $table->foreign('tag_id')->references('id')->on('tags');
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
            $table->dropIndex('espacios_ofrecidos_LIST_tag_id_foreign');
            $table->dropColumn('tag_id');
        });
    }
}
