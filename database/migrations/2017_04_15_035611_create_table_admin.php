<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_admin', function(Blueprint $table) {
             $table->increments('id');
             $table->string('username', 12);
             $table->string('password', 100);
             $table->datetime('last_login_date')->nullable();
             $table->datetime('last_login_ip')->nullable();
             $table->string('last_login_country', 2)->nullable();
             $table->string('key_code', 80);
             $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_admin');
    }
}
