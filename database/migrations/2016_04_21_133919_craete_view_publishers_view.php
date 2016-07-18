<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CraeteViewPublishersView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW bd_view_publishers AS (
            select 
                bd_us_reg_LIST.id_us_LI as id,
                bd_actividades_economicas_LIST.id as economic_activity_id,
                bd_actividades_economicas_LIST.nombre as economic_activity_name,
                comentarios_us_LI comments,
                bd_ciudades.ciudad as city_name,
                bd_ciudades.id_ciudad as city_id,
                fecha_registro_Us_LI as created_at, bd_us_reg_LIST.fecha_activacion_Us_LI as activated_at,
                nombre_us_LI as first_name, apellido_us_LI as last_name,
                telefono_fijo_us_LI as phone, celular_us_LI as cel,
                CONCAT(nombre_us_LI, ' ', apellido_us_LI) as name,
                empresa_us_LI as company, nit_empresa_us_LI as company_nit, cargo_us_LI as company_role, area_cargo_us_LI as company_area,
                email_us_LI as email, direccion_us_LI as address,
                (CASE WHEN bd_us_reg_LIST.firmo_acuerdo_LI = 'No_fir_ac' THEN FALSE ELSE TRUE END) as signed_agreement,
                fecha_firma_acuerdo_us_LI as signed_at, porc_comision_us_LI as commission_rate, 
                retencion_fuente_us_LI as retention, descuento_pronto_pago_us_LI as discount,
                (CASE WHEN bd_us_reg_cod_LIST.usuario_act_LI = 'usActnO' THEN FALSE ELSE TRUE END) as email_validated,
                (CASE WHEN bd_us_reg_LIST.es_us_activo_LI = 'act_Sta' THEN TRUE ELSE FALSE END) as complete_data,
                user_id
            from bd_us_reg_LIST
            LEFT JOIN bd_us_reg_cod_LIST ON bd_us_reg_cod_LIST.id_us_LI = bd_us_reg_LIST.id_us_LI
            LEFT JOIN bd_actividades_economicas_LIST ON bd_actividades_economicas_LIST.id = bd_us_reg_LIST.id_actividadEconomica_LI
            LEFT JOIN bd_ciudades ON bd_ciudades.id_ciudad = bd_us_reg_LIST.id_ciudad_LI
            WHERE tipo_us_LI = 'Ve_tip_u')
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            DROP VIEW bd_view_publishers
        ");
    }
}
