<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();

        Admin::create([
        	'username' => 'admin',
        	'password' => bcrypt(123456),
        	'key_code' => str_random(8)
        ]);
    }
}
