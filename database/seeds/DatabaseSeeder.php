<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(AdminSeeder::class);
        $this->call(Codes216Seeder::class);
        $this->call(Codes236Seeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(FilenasSeeder::class);
        $this->call(FilenasStatusSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(TransactionsStatusSeeder::class);
        $this->call(TransactionsTypeSeeder::class);
    }
}
