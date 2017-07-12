<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TABLE `chs_user_stats` (
          `id` int(10) UNSIGNED NOT NULL,
          `date` date NOT NULL,
          `user_id` int(11) NOT NULL,
          `uploads` int(11) NOT NULL DEFAULT '0',
          `downloads` int(11) NOT NULL DEFAULT '0',
          `website_downloads` int(11) NOT NULL,
          `transactions` int(11) NOT NULL,
          `rebills` int(11) NOT NULL,
          `revenue` decimal(10,2) NOT NULL,
          `website_transactions` int(11) NOT NULL,
          `website_rebills` int(11) NOT NULL,
          `website_revenue` decimal(10,2) NOT NULL,
          `files_download` int(11) NOT NULL,
          `bytes_downloaded` bigint(20) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        
        DB::statement('ALTER TABLE `chs_user_stats` ADD PRIMARY KEY (`id`);');
        DB::statement('ALTER TABLE `chs_user_stats` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_user_stats');
    }
}
