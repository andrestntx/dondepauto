<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('us_reg_LIST', function (Blueprint $table) {
            $table->string('banco_LI');
            $table->string('cuenta_banco_LI');
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
            $table->dropColumn(['banco_LI', 'cuenta_banco_LI']);
        });
    }
}
