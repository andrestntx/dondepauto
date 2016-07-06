<?php

use App\Entities\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    protected  $faker;
    /**
     * UsersTableSeeder constructor.
     * @param $faker
     */
    public function __construct(Faker\Generator $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 'director')->create([
            'email' => 'admin@dondepauto.co'
        ]);

        App\Entities\Platform\Space\AudienceType::create([
            'name' => 'Edad'
        ]);

        App\Entities\Platform\Space\AudienceType::create([
            'name' => 'Sexo'
        ]);

        App\Entities\Platform\Space\Audience::create([
            'name' => 'Niños',
            'audience_type_id' => 1,
        ]);

        App\Entities\Platform\Space\Audience::create([
            'name' => 'Jovenes',
            'audience_type_id' => 1,
        ]);

        App\Entities\Platform\Space\Audience::create([
            'name' => 'Adultos',
            'audience_type_id' => 1,
        ]);

        App\Entities\Platform\Space\Audience::create([
            'name' => 'Mujeres',
            'audience_type_id' => 2,
        ]);

        App\Entities\Platform\Space\Audience::create([
            'name' => 'Hombres',
            'audience_type_id' => 2,
        ]);
        
        //factory(User::class, 60)->create();
    }
}
