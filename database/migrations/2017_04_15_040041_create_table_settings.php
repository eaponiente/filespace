<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TABLE `chs_settings` (
                  `free_user_max_download_speed` int(11) NOT NULL DEFAULT '0',
                  `register_user_max_download_speed` int(11) NOT NULL DEFAULT '0',
                  `premium_user_max_download_speed` int(11) NOT NULL DEFAULT '0',
                  `free_users_remove_inactive_days` int(11) NOT NULL DEFAULT '0',
                  `register_user_remove_inactive_days` int(11) NOT NULL DEFAULT '0',
                  `premium_user_remove_inactive_days` int(11) NOT NULL DEFAULT '0',
                  `registered_user_storage` bigint(20) DEFAULT NULL,
                  `premium_user_storage` bigint(20) DEFAULT NULL,
                  `minimum_pay_wmz` int(11) NOT NULL DEFAULT '0',
                  `minimum_pay_paypal` int(11) NOT NULL DEFAULT '0',
                  `minimum_pay_wire` int(11) NOT NULL DEFAULT '0',
                  `free_user_download_interval` int(11) NOT NULL DEFAULT '0',
                  `register_user_download_interval` int(11) NOT NULL DEFAULT '0',
                  `free_users_delay` int(11) NOT NULL DEFAULT '0',
                  `register_users_delay` int(11) NOT NULL DEFAULT '0',
                  `free_user_max_download_transfer_per_day` int(11) NOT NULL DEFAULT '0',
                  `registered_user_max_download_transfer_per_day` int(11) NOT NULL DEFAULT '0',
                  `premium_user_max_download_transfer_per_day` int(11) NOT NULL DEFAULT '0',
                  `free_download_token_expire_datetime` int(11) DEFAULT NULL,
                  `registered_download_token_expire_datetime` int(11) NOT NULL,
                  `premium_download_token_expire_datetime` int(11) NOT NULL,
                  `download_update_frequency` int(11) NOT NULL,
                  `id` int(10) UNSIGNED NOT NULL
                )");

        DB::statement('ALTER TABLE `chs_settings` ADD PRIMARY KEY (`id`);');
        DB::statement('ALTER TABLE `chs_settings` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_settings');
    }
}
