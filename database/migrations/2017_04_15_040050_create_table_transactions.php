<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TABLE `chs_transactions` (
          `id` int(11) NOT NULL,
          `trans_datetime` datetime NOT NULL,
          `ip` varchar(15) DEFAULT NULL,
          `ip_geocountry` varchar(2) DEFAULT NULL,
          `status` int(11) NOT NULL DEFAULT '0',
          `type` int(11) NOT NULL DEFAULT '0',
          `card type` varchar(80) NOT NULL,
          `user_id` int(11) NOT NULL DEFAULT '0',
          `user_timezone` varchar(100) DEFAULT NULL,
          `affiliate_id` int(11) NOT NULL DEFAULT '0',
          `affiliate_referral_id` int(11) NOT NULL DEFAULT '0',
          `transaction_amount` decimal(8,2) NOT NULL,
          `affiliate_payout` decimal(8,2) NOT NULL DEFAULT '0.00',
          `affiliate_referral_payout` decimal(8,2) NOT NULL DEFAULT '0.00',
          `site_owner_payout` decimal(8,2) NOT NULL DEFAULT '0.00',
          `profit` int(11) NOT NULL DEFAULT '0',
          `site_owner_id` int(11) NOT NULL DEFAULT '0',
          `premium_days` int(11) NOT NULL DEFAULT '0',
          `premium_start` datetime NOT NULL,
          `premium_end` datetime NOT NULL,
          `referring_domain` varchar(200) NOT NULL,
          `credit_card_name` varchar(80) NOT NULL,
          `credit card number` int(11) NOT NULL,
          `credit card last 3 digits` int(11) NOT NULL,
          `card_expiration_date` date NOT NULL,
          `credit_card_country` varchar(80) NOT NULL,
          `credit_card_pay_id` int(11) NOT NULL DEFAULT '0',
          `credit_card_merchant_ref_id` int(11) NOT NULL DEFAULT '0',
          `paypal_transaction_id` varchar(80) NOT NULL,
          `voucher_id` int(11) NOT NULL DEFAULT '0',
          `voucher` varchar(80) NOT NULL,
          `promo_code_id` int(11) NOT NULL DEFAULT '0',
          `promo_code_pin` int(11) NOT NULL DEFAULT '0'
        )");
    
        DB::statement('ALTER TABLE `chs_transactions` ADD PRIMARY KEY (`id`);');
        DB::statement('ALTER TABLE `chs_transactions` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_transactions');
    }
}
