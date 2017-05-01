<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewImpactScenesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW bd_view_impact_scenes AS (
                select bd_proposal_space.proposal_id, 
                bd_tipos_lugares_ubicacion_espacios_LIST.id_tipo_lugar_LI as id, bd_tipos_lugares_ubicacion_espacios_LIST.nombre_tipo_lugar_LI as name
                FROM bd_view_spaces 
                JOIN bd_proposal_space ON 
                    bd_proposal_space.space_id = bd_view_spaces.id
                JOIN bd_impact_scene_space ON 
                    bd_impact_scene_space.space_id = bd_view_spaces.id
                JOIN bd_tipos_lugares_ubicacion_espacios_LIST ON
                    bd_tipos_lugares_ubicacion_espacios_LIST.id_tipo_lugar_LI = bd_impact_scene_space.impact_scene_id
                GROUP BY bd_proposal_space.proposal_id, bd_impact_scene_space.impact_scene_id

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
            DROP VIEW bd_view_impact_scenes
        ");
    }
}
