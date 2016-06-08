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
            'email'         => 'admin@dondepauto.co'
        ]);
        
        //factory(User::class, 60)->create();
    }
}
