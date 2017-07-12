<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFilenas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_filenas', function(Blueprint $table) {
             $table->increments('id');
             $table->string('serverLabel', 100);
             $table->enum('serverType', ['remote','local','ftp','sftp','direct'])->nullable();
             $table->string('ipAddress', 100)->nullable();
             $table->integer('ftpPort')->nullable();
             $table->string('ftpUsername', 50)->nullable();
             $table->string('ftpPassword', 50)->nullable();
             $table->string('sftpHost', 255)->nullable();
             $table->integer('sftpPort')->nullable();
             $table->string('sftpUsername', 50)->nullable();
             $table->string('sftpPassword', 50)->nullable();
             $table->integer('statusId')->default('1');
             $table->string('storagePath', 255)->nullable();
             $table->string('fileServerDomainName')->nullable();
             $table->string('scriptPath', 150)->nullable();
             $table->integer('files')->default('0');
             $table->bigInteger('space_used')->nullable();
             $table->bigInteger('total_space')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_filenas');
    }
}
