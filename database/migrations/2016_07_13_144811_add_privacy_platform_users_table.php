<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrivacyPlatformUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('us_reg_LIST', function (Blueprint $table) {
            $table->boolean('opcion_espacios_privados_LI')->default(false);
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
            $table->dropColumn(['opcion_espacios_privados_LI']);
        });
    }
}
