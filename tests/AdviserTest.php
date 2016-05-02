<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdviserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $user = $this->createTestUser('director');

        $this->actingAs($user)
            ->visit('/asesores')
            ->click('Crear Asesor')
            ->type('first',  'first_name')
            ->type('last',  'last_name')
            ->type('secret', 'password')
            ->type('secret', 'password_confirmation')
            ->type('test@dondepauto.co',  'email')
            ->press('Guardar Asesor')
            ->seePageIs(route('asesores.index'))
            ->seeInDatabase('users', [
                'email' => 'test@dondepauto.co',
            ]);
    }

    public function testEdit()
    {
        $user = $this->createTestUser('director');
        $adviser = $this->createTestUser('adviser');

        $this->actingAs($user)
            ->visit(route('asesores.edit', $adviser))
            ->type('first',  'first_name')
            ->type('last',  'last_name')
            ->type('secret', 'password')
            ->type('secret', 'password_confirmation')
            ->type('testedit@dondepauto.co',  'email')
            ->press('Guardar Asesor')
            ->seePageIs(route('asesores.index'))
            ->seeInDatabase('users', [
                'email' => 'testedit@dondepauto.co',
            ]);
    }
}
