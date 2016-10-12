<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTagIdPlatformUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('us_reg_LIST', function (Blueprint $table) {
            $table->integer('tag_id')->nullable();
            $table->foreign('tag_id')->references('id_us_LI')->on('us_reg_LIST');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('us_reg_LIST', function (Blueprint $table) {
            $table->dropIndex('us_reg_list_tag_id_foreign');
            $table->dropColumn('tag_id');
        });
    }
}
