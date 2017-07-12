<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDownloadTracker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_download_tracker', function(Blueprint $table) {
             $table->increments('id');
             $table->integer('file_id');
             $table->string('ip_address', 30);
             $table->string('download_username', 65)->nullable();
             $table->datetime('date_started');
             $table->datetime('date_updated')->nullable();
             $table->datetime('date_finished')->nullable();
             $table->enum('status', ['downloading','finished','error','cancelled']);
             $table->bigInteger('start_offset')->nullable();
             $table->bigInteger('seek_end')->nullable();
             $table->integer('website_code_id')->nullable();
             $table->string('download_country', 20)->nullable();
             $table->string('referring_url', 200)->nullable();
             $table->integer('download_speed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_download_tracker');
    }
}
