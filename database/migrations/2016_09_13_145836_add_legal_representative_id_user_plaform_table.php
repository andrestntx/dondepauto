<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLegalRepresentativeIdUserPlaformTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('us_reg_LIST', function (Blueprint $table) {
            $table->integer('legal_representative_id')->nullable()->unsigned();
            $table->foreign('legal_representative_id')->references('id')->on('legal_representatives');
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
            $table->dropIndex('us_reg_list_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
