<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdminStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_admin_stats', function(Blueprint $table) {
             $table->increments('id');
             $table->datetime('date');
             $table->integer('uploads');
             $table->integer('downloads');
             $table->integer('data_transfer');
             $table->integer('sales');
             $table->integer('rebills');
             $table->integer('revenue');
             $table->integer('affiliate_revenue');
             $table->integer('sites_revenue');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_admin_stats');
    }
}
