<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TABLE `chs_vouchers` (
          `id` int(11) NOT NULL,
          `reseller_id` int(11) NOT NULL DEFAULT '0',
          `generation_datetime` datetime NOT NULL,
          `is_used` tinyint(4) NOT NULL DEFAULT '0',
          `premium_days` int(11) NOT NULL DEFAULT '0',
          `code` varchar(80) NOT NULL,
          `is_generated_by` varchar(80) NOT NULL,
          `generated_user_id` int(11) DEFAULT NULL,
          `used_user_id` int(11) DEFAULT NULL,
          `consumed_datetime` datetime DEFAULT NULL,
          `pin` tinyint(4) NOT NULL
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;");
        
        DB::statement('ALTER TABLE `chs_vouchers` ADD PRIMARY KEY (`id`);');
        DB::statement('ALTER TABLE `chs_vouchers` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_vouchers');
    }
}
