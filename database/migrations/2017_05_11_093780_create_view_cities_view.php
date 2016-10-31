<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewCitiesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW bd_view_cities AS (
                select bd_proposal_space.proposal_id, 
                bd_ciudades_LIST.id_ciudad_LI as id, bd_ciudades_LIST.nombre_ciudad_LI as name
                FROM bd_view_spaces 
                JOIN bd_proposal_space ON 
                    bd_proposal_space.space_id = bd_view_spaces.id
                JOIN bd_city_space ON 
                    bd_city_space.space_id = bd_view_spaces.id
                JOIN bd_ciudades_LIST ON
                    bd_ciudades_LIST.id_ciudad_LI = bd_city_space.city_id
                GROUP BY bd_proposal_space.proposal_id, bd_city_space.city_id
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
            DROP VIEW bd_view_cities
        ");
    }
}
