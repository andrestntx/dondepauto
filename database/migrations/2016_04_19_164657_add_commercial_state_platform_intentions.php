<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommercialStatePlatformIntentions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bd_intenciones_compra_espacios_ofrecidos_LIST', function (Blueprint $table) {
            $table->enum('commercial_state', ['by_contact', 'management', 'sold', 'discarded'])->default('by_contact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bd_intenciones_compra_espacios_ofrecidos_LIST', function (Blueprint $table) {
            $table->dropColumn('commercial_state');
        });
    }
}
