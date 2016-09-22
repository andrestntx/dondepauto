<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_role');

            $table->dropForeign('proposals_advertiser_id_foreign');
            $table->dropColumn('advertiser_id');

            $table->renameColumn('name', 'title');

            $table->integer('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('contact_name');
            $table->string('contact_role');

            $table->integer('advertiser_id');
            $table->foreign('advertiser_id')->references('id_us_LI')->on('us_reg_LIST'); 

            $table->renameColumn('title', 'name');

            $table->dropForeign('proposals_quote_id_foreign');
            $table->dropColumn('quote_id');
        });
    }
}
