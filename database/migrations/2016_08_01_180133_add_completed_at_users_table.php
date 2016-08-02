<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompletedAtUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('us_reg_LIST', function (Blueprint $table) {
            $table->timestamp("fecha_registro_completo_Us_LI")->nullable();
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
            $table->dropColumn("fecha_registro_completo_Us_LI");
        });
    }
}
