<?php

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Settings::truncate();

        DB::statement("INSERT INTO `chs_settings` (`free_user_max_download_speed`, `register_user_max_download_speed`, `premium_user_max_download_speed`, `free_users_remove_inactive_days`, `register_user_remove_inactive_days`, `premium_user_remove_inactive_days`, `registered_user_storage`, `premium_user_storage`, `minimum_pay_wmz`, `minimum_pay_paypal`, `minimum_pay_wire`, `free_user_download_interval`, `register_user_download_interval`, `free_users_delay`, `register_users_delay`, `free_user_max_download_transfer_per_day`, `registered_user_max_download_transfer_per_day`, `premium_user_max_download_transfer_per_day`, `free_download_token_expire_datetime`, `registered_download_token_expire_datetime`, `premium_download_token_expire_datetime`, `download_update_frequency`, `id`) VALUES
			(300, 1000, 10000, 0, 0, 0, 10737418240, 1073741824000, 0, 0, 0, 60, 60, 60, 30, 2, 5, 100, 2, 0, 0, 10, 1);");
    }
}
