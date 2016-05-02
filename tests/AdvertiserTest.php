<?php

/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 25/04/2016
 * Time: 10:00 AM
 */

use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdvertiserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $director = $this->createTestUser('director');
        $adviser = $this->createTestUser('adviser');

        $this->actingAs($director)
            ->visit('/anunciantes/create')
            ->type('first',  'first_name')
            ->type('last',  'last_name')
            ->type('test@dondepauto.co',  'email')
            ->press('Guardar Cambios')
            ->seePageIs(route('anunciantes.index'))
            ->seeInDatabase('bd_us_reg_LIST', [
                'email_us_LI' => 'test@dondepauto.co',
                'tipo_us_LI'  => 'Co_tip_u'
            ]);
    }
}
