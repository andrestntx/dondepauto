<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdviserOldUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('us_reg_LIST', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
            $table->dropIndex('bd_us_reg_list_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
