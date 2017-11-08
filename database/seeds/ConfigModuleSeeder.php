<?php

use Illuminate\Database\Seeder;

class ConfigModuleSeeder extends Seeder
{
    public function run()
    {
        \App\Entities\Platform\ConfigModule::create([
            'name' => 'direct_contact',
            'start' => false
        ]);
    }
}
