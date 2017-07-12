<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFileFolders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_file_folders', function(Blueprint $table) {
             $table->increments('id');
             $table->string('folder_name', 80)->nullable();
             $table->integer('user_id');
             $table->datetime('date_created');
             $table->integer('total_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_file_folders');
    }
}
