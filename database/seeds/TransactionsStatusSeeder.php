<?php

use App\Models\TransactionStatus;
use Illuminate\Database\Seeder;

class TransactionsStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionStatus::truncate();

        TransactionStatus::insert([
        	['status_name' => 'Rejected By Bank', 'is_active' => 1],
        	['status_name' => 'To Verify', 'is_active' => 1],
        	['status_name' => 'Auto Approved', 'is_active' => 1],
        	['status_name' => 'Manually Approved', 'is_active' => 1],
        	['status_name' => 'Refunded', 'is_active' => 1],
        	['status_name' => 'Charged Back', 'is_active' => 1]
        ]);
    }
}
