<?php

use App\Models\FilenasStatus;
use Illuminate\Database\Seeder;

class FilenasStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	FilenasStatus::truncate();

        FilenasStatus::insert([
        	['label' => 'disabled'],
        	['label' => 'active'],
        	['label' => 'read only']
        ]);
    }
}
