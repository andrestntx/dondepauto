<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewSpacesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW bd_view_spaces AS (
                select bd_espacios_ofrecidos_LIST.id_espacio_LI as id, bd_espacios_ofrecidos_LIST.impacto_espacio_LI as impacts, bd_espacios_ofrecidos_LIST.tag_id,
                bd_cat_espacios_ofrecidos_LIST.id_cat_LI as category_id, bd_cat_espacios_ofrecidos_LIST.nombre_cat_LI as category_name,
                bd_subcat_espacios_ofrecidos_LIST.id_subcat_LI as sub_category_id, bd_subcat_espacios_ofrecidos_LIST.nombre_subcat_LI as sub_category_name,
                bd_formatos_espacios_ofrecidos_LIST.id_formato_LI as format_id, bd_formatos_espacios_ofrecidos_LIST.nombre_formato_LI as format_name,
                bd_ciudades_LIST.id_ciudad_LI as city_id, bd_ciudades_LIST.nombre_ciudad_LI as city_name,
                bd_tipos_lugares_ubicacion_espacios_LIST.id_tipo_lugar_LI as impact_scene_id, bd_tipos_lugares_ubicacion_espacios_LIST.nombre_tipo_lugar_LI as impact_scene_name,
                bd_view_publishers.id as publisher_id, bd_view_publishers.first_name as publisher_first_name, bd_view_publishers.last_name as publisher_last_name, bd_view_publishers.company as publisher_company, 
                bd_view_publishers.cel as publisher_cel, bd_view_publishers.phone as publisher_phone, bd_view_publishers.email as publisher_email, 
                bd_view_publishers.economic_activity_name as publisher_economic_activity_name, bd_view_publishers.company_nit as publisher_company_nit, bd_view_publishers.company_role as publisher_company_role, 
                bd_view_publishers.company_area as publisher_company_area, bd_view_publishers.signed_agreement as publisher_signed_agreement, 
                bd_view_publishers.signed_at as publisher_signed_at, bd_view_publishers.commission_rate as publisher_commission_rate, bd_view_publishers.retention as publisher_retention,
                bd_view_publishers.discount as publisher_discount,
                bd_espacios_ofrecidos_LIST.fecha_creacion_LI as created_at,
                bd_espacios_ofrecidos_LIST.nombre_espacio_LI as name, bd_espacios_ofrecidos_LIST.descripcion_espacio_LI as description,
                bd_espacios_ofrecidos_LIST.tags_espacio_LI as tags, bd_espacios_ofrecidos_LIST.direccion_ubicacion_LI as address,
                bd_espacios_ofrecidos_LIST.urlTag as url, bd_espacios_ofrecidos_LIST.dimensiones_espacio_LI as dimensions,
                bd_espacios_ofrecidos_LIST.descuento_espacio_LI as discount,
                (CASE WHEN bd_espacios_ofrecidos_LIST.espacio_activo_LI = 'Si_act' THEN TRUE ELSE FALSE END) as active,
                (CASE WHEN bd_espacios_ofrecidos_LIST.restringeAlcohol_LI = 'S' THEN TRUE ELSE FALSE END) as alcohol_restriction,
                (CASE WHEN bd_espacios_ofrecidos_LIST.restringeTabaco_LI = 'S' THEN TRUE ELSE FALSE END) as snuff_restriction,
                (CASE WHEN bd_espacios_ofrecidos_LIST.restringePolitica_LI = 'S' THEN TRUE ELSE FALSE END) as policy_restriction,
                bd_espacios_ofrecidos_LIST.precio_espacio_LI as minimal_price, bd_espacios_ofrecidos_LIST.porcentaje_precio_margen_espacio_LI as percentage_markup,
                (bd_espacios_ofrecidos_LIST.precio_espacio_LI * bd_espacios_ofrecidos_LIST.porcentaje_precio_margen_espacio_LI) as markup_price,
                ((bd_espacios_ofrecidos_LIST.precio_espacio_LI * bd_espacios_ofrecidos_LIST.porcentaje_precio_margen_espacio_LI) + bd_espacios_ofrecidos_LIST.precio_espacio_LI) as public_price,
                (((1 / (1 + bd_espacios_ofrecidos_LIST.porcentaje_precio_margen_espacio_LI)) - 1) * -1)  as percentage_markdown,
                bd_espacios_ofrecidos_LIST.periodo_servicio_espacio_LI as period,
                (CASE WHEN bd_espacios_ofrecidos_LIST.espacio_eliminado_LI = 'Si_el' THEN TRUE ELSE FALSE END) as is_delete
                from bd_espacios_ofrecidos_LIST
                JOIN bd_view_publishers ON
                    bd_view_publishers.id = bd_espacios_ofrecidos_LIST.id_us_reg_LI AND 
                    bd_view_publishers.deleted_at IS NULL
                LEFT JOIN bd_formatos_espacios_ofrecidos_LIST ON 
                    bd_formatos_espacios_ofrecidos_LIST.id_formato_LI = bd_espacios_ofrecidos_LIST.id_formato_LI
                LEFT JOIN bd_subcat_espacios_ofrecidos_LIST ON 
                    bd_subcat_espacios_ofrecidos_LIST.id_subcat_LI = bd_formatos_espacios_ofrecidos_LIST.id_subcat_LI
                LEFT JOIN bd_cat_espacios_ofrecidos_LIST ON
                    bd_cat_espacios_ofrecidos_LIST.id_cat_LI = bd_subcat_espacios_ofrecidos_LIST.id_cat_LI
                LEFT JOIN bd_tipos_lugares_ubicacion_espacios_LIST ON
                    bd_tipos_lugares_ubicacion_espacios_LIST.id_tipo_lugar_LI = bd_espacios_ofrecidos_LIST.id_tipo_lugar_ubicacion_LI
                LEFT JOIN bd_ciudades_LIST ON
                    bd_ciudades_LIST.id_ciudad_LI = bd_espacios_ofrecidos_LIST.id_ciudad_LI
            )
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
            DROP VIEW bd_view_spaces
        ");
    }
}
