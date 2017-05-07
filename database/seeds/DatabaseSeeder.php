<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Eloquent::unguard();
        //call uses table seeder class
        $this->call('KrajeTableSeeder');
        //this message shown in your terminal after running db:seed command
        $this->command->info("Kraje table seeded :)");
    }

}

class KrajeTableSeeder extends Seeder {

    public function run()
    {
        //delete users table records
        DB::table('kraj')->delete();
        //insert some dummy records
        DB::table('kraj')->insert(
            array(
                array('kraj' => 'Bratislavský'),
                array('kraj' => 'Trnavský'),
                array('kraj' => 'Trenčiansky'),
                array('kraj' => 'Nitriansky'),
                array('kraj' => 'Žilinský'),
                array('kraj' => 'Banskobystrický'),
                array('kraj' => 'Prešovský'),
                array('kraj' => 'Košický')

            ));
    }
}
