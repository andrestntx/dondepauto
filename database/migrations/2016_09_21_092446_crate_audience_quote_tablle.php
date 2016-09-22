<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateAudienceQuoteTablle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audience_quote', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('audience_id')->unsigned();
            $table->foreign('audience_id')->references('id')->on('audiences');

            $table->integer('quote_id')->unsigned();
            $table->foreign('quote_id')->references('id')->on('quotes');

            $table->unique(['audience_id', 'quote_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('audience_quote');
    }
}
