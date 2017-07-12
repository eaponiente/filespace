<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFileUploads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_file_uploads', function(Blueprint $table) {
             $table->increments('id');
             $table->integer('parent_id')->nullable();
             $table->string('file_md5', 200);
             $table->string('delete_hash', 32);
             $table->string('filename', 100);
             $table->string('file_path', 200);
             $table->string('file_ext', 80);
             $table->string('title', 150)->nullable();
             $table->integer('folder_id');
             $table->integer('user_id')->nullable();
             $table->datetime('datetime_uploaded');
             $table->string('upload_ip', 15);
             $table->bigInteger('filesize_bytes');
             $table->datetime('last_download')->nullable();
             $table->tinyInteger('is_public')->default('0');
             $table->tinyInteger('is_premium_only')->default('0');
             $table->integer('filenas_id');
             $table->integer('fileserver_id');
             $table->integer('total_downloads');
             $table->string('password', 6);
             $table->string('country_code', 80);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_file_uploads');
    }
}
