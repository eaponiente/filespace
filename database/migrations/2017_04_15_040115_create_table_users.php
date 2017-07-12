<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TABLE `chs_users` (
              `id` int(11) NOT NULL,
              `status` enum('1','2','3') NOT NULL DEFAULT '3',
              `referral_id` int(11) NOT NULL DEFAULT '0',
              `username` varchar(80) NOT NULL,
              `password` varchar(80) NOT NULL,
              `email` varchar(80) NOT NULL,
              `registration_date` datetime DEFAULT NULL,
              `registration_ip` varchar(15) DEFAULT NULL,
              `registration_geocountry` varchar(80) NOT NULL,
              `confirmation_date` datetime DEFAULT NULL,
              `confirmation_ip` varchar(15) DEFAULT NULL,
              `confirmation_geocountry` varchar(80) DEFAULT NULL,
              `premium_expiration_date_and_time` datetime DEFAULT NULL,
              `last_transaction_credit_card_geocountry` varchar(80) DEFAULT NULL,
              `is_last_transaction_verified` enum('No','Yes') NOT NULL DEFAULT 'No',
              `1st_download_geocountry` varchar(80) DEFAULT NULL,
              `2nd_download_geocountry` varchar(80) DEFAULT NULL,
              `3rd_download_geocountry` varchar(80) DEFAULT NULL,
              `4th_download_geocountry` varchar(80) DEFAULT NULL,
              `5th_download_geocountry` int(80) DEFAULT NULL,
              `bonus` int(11) NOT NULL DEFAULT '0',
              `payment_method` int(10) UNSIGNED DEFAULT NULL,
              `payment_account` varchar(80) DEFAULT NULL,
              `payment_method_pending` varchar(80) DEFAULT NULL,
              `payment_account_pending account` varchar(80) DEFAULT NULL,
              `paid_premium` set('0','1') NOT NULL DEFAULT '0',
              `is_affiliate` enum('YES','NO') NOT NULL DEFAULT 'NO',
              `hash_id` varchar(32) DEFAULT NULL,
              `key_code` varchar(80) NOT NULL,
              `balance_amount` decimal(6,4) NOT NULL DEFAULT '0.0000',
              `last_visited` datetime DEFAULT NULL,
              `custom_storage` bigint(20) DEFAULT NULL,
              `files` int(11) UNSIGNED NOT NULL DEFAULT '0',
              `storage_used` bigint(20) DEFAULT NULL,
              `folders` int(11) UNSIGNED NOT NULL DEFAULT '0',
              `key_code_purpose` varchar(80) NOT NULL DEFAULT '',
              `key_code_expired` datetime DEFAULT NULL COMMENT 'datetime of keycode generation + 24 hours = key_code_expired',
              `ref_user_id` int(10) UNSIGNED DEFAULT NULL,
              `ref_site_id` int(10) UNSIGNED DEFAULT NULL,
              `website_code_id` int(11) DEFAULT NULL,
              `affiliate_ash` varchar(16) DEFAULT NULL,
              `user_code` varchar(10) DEFAULT NULL,
              `remember_token` varchar(128) DEFAULT NULL
            ) ");

        DB::statement('ALTER TABLE `chs_users` ADD PRIMARY KEY (`id`);');
        DB::statement('ALTER TABLE `chs_users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_users');
    }
}
