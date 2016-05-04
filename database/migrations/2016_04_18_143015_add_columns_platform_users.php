<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsPlatformUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bd_us_reg_LIST', function (Blueprint $table) {
            $table->double('descuento_pronto_pago_us_LI')->nullable();
            $table->double('porc_comision_us_LI')->nullable();
            $table->double('retencion_fuente_us_LI')->nullable();
            $table->date('fecha_firma_acuerdo_us_LI')->nullable();
            $table->string('mailchimp_id')->nullable();
            $table->text('comentarios_us_LI')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bd_us_reg_LIST', function (Blueprint $table) {
            $table->dropColumn('descuento_pronto_pago_us_LI');
            $table->dropColumn('porc_comision_us_LI');
            $table->dropColumn('retencion_fuente_us_LI');
            $table->dropColumn('fecha_firma_acuerdo_us_LI');
            $table->dropColumn('mailchimp_id');
            $table->dropColumn('comentarios_us_LI');
        });
    }
}
