<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_countries', function(Blueprint $table) {
             $table->increments('id');
             $table->string('code', 2);
             $table->string('full_name', 80);
             $table->tinyInteger('is_banned')->comment('0=not banned, 1=banned');
             $table->datetime('datetime_banned')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_countries');
    }
}
