<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWebsiteCodeStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_website_code_stats', function(Blueprint $table) {
             $table->increments('id');
             $table->date('date');
             $table->integer('website_owner_user_id');
             $table->integer('website_code_id');
             $table->integer('downloads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_website_code_stats');
    }
}
