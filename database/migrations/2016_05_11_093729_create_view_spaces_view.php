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
            CREATE VIEW view_spaces AS (
                select bd_cat_espacios_ofrecidos_LIST.id_cat_LI as category_id, bd_cat_espacios_ofrecidos_LIST.nombre_cat_LI as category_name,
                bd_subcat_espacios_ofrecidos_LIST.id_subcat_LI as sub_category_id, bd_subcat_espacios_ofrecidos_LIST.nombre_subcat_LI as sub_category_name,
                bd_formatos_espacios_ofrecidos_LIST.id_formato_LI as format_id, bd_formatos_espacios_ofrecidos_LIST.nombre_formato_LI as format_name,
                bd_ciudades_LIST.id_ciudad_LI as city_id, bd_ciudades_LIST.nombre_ciudad_LI as city_name,
                bd_tipos_lugares_ubicacion_espacios_LIST.id_tipo_lugar_LI as impact_scene_id, bd_tipos_lugares_ubicacion_espacios_LIST.nombre_tipo_lugar_LI as impact_scene_name,
                view_publishers.id as publisher_id, view_publishers.first_name as publisher_first_name, view_publishers.last_name as publisher_last_name, view_publishers.company as publisher_company,
                bd_espacios_ofrecidos_LIST.fecha_creacion_LI as created_at,
                bd_espacios_ofrecidos_LIST.nombre_espacio_LI as name, bd_espacios_ofrecidos_LIST.descripcion_espacio_LI as description,
                bd_espacios_ofrecidos_LIST.tags_espacio_LI as tags, bd_espacios_ofrecidos_LIST.direccion_ubicacion_LI as address,
                bd_espacios_ofrecidos_LIST.urlTag as url, bd_espacios_ofrecidos_LIST.dimensiones_espacio_LI as dimensions,
                (CASE WHEN bd_espacios_ofrecidos_LIST.espacio_activo_LI = 'Si_act' THEN TRUE ELSE FALSE END) as active,
                bd_espacios_ofrecidos_LIST.precio_espacio_LI as minimal_price, bd_espacios_ofrecidos_LIST.porcentaje_precio_margen_espacio_LI as percentage_markup,
                (((1 / (1 + bd_espacios_ofrecidos_LIST.porcentaje_precio_margen_espacio_LI)) - 1) * -1)  as percentage_markdown,
                bd_espacios_ofrecidos_LIST.periodo_servicio_espacio_LI as period,
                (CASE WHEN bd_espacios_ofrecidos_LIST.espacio_eliminado_LI = 'Si_el' THEN TRUE ELSE FALSE END) as is_delete
                from bd_espacios_ofrecidos_LIST
                JOIN view_publishers ON
                    view_publishers.id = bd_espacios_ofrecidos_LIST.id_us_reg_LI
                JOIN bd_formatos_espacios_ofrecidos_LIST ON 
                    bd_formatos_espacios_ofrecidos_LIST.id_formato_LI = bd_espacios_ofrecidos_LIST.id_formato_LI
                JOIN bd_subcat_espacios_ofrecidos_LIST ON 
                    bd_subcat_espacios_ofrecidos_LIST.id_subcat_LI = bd_formatos_espacios_ofrecidos_LIST.id_subcat_LI
                JOIN bd_cat_espacios_ofrecidos_LIST ON
                    bd_cat_espacios_ofrecidos_LIST.id_cat_LI = bd_subcat_espacios_ofrecidos_LIST.id_cat_LI
                JOIN bd_tipos_lugares_ubicacion_espacios_LIST ON
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
            DROP VIEW view_spaces
        ");
    }
}
