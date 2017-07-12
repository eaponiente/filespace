<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDownloadToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_download_token', function(Blueprint $table) {
             $table->increments('id');
             $table->string('token', 64);
             $table->integer('user_id');
             $table->string('ip_address', 15);
             $table->integer('file_id');
             $table->datetime('created');
             $table->datetime('expiry');
             $table->integer('download_speed');
             $table->integer('max_threads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_download_token');
    }
}
