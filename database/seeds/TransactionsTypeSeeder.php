<?php

use App\Models\TransactionsType;
use Illuminate\Database\Seeder;

class TransactionsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionsType::truncate();

        TransactionsType::insert([
        	['type_name' => 'Webmoney', 'is_active' => 1],
        	['type_name' => 'Paypal', 'is_active' => 1]
        ]);
    }
}
