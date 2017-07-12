<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGlobalStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_global_stats', function(Blueprint $table) {
             $table->increments('id');
             $table->date('date');
             $table->integer('uploads')->default(0);
             $table->integer('downloads')->default(0);
             $table->integer('new_users')->default(0);
             $table->integer('abuses')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_global_stats');
    }
}
