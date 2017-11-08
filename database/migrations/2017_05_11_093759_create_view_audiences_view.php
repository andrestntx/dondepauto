<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewAudiencesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW bd_view_audiences AS (
                select bd_proposal_space.proposal_id, 
                bd_audience_types.name as type_name, bd_audience_types.image as type_img,
                bd_audiences.*
                FROM bd_view_spaces 
                JOIN bd_proposal_space ON 
                    bd_proposal_space.space_id = bd_view_spaces.id
                JOIN bd_audience_space ON 
                    bd_audience_space.space_id = bd_view_spaces.id
                JOIN bd_audiences ON
                    bd_audiences.id = bd_audience_space.audience_id
                JOIN bd_audience_types ON 
                    bd_audience_types.id = bd_audiences.audience_type_id
                GROUP BY bd_proposal_space.proposal_id, bd_audiences.id
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
            DROP VIEW bd_view_audiences
        ");
    }
}
