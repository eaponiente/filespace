<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableResellers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_resellers', function(Blueprint $table) {
           $table->increments('id');
           $table->string('username', 80)->unique();
           $table->string('password', 130);
           $table->enum('status', ['active','disabled']);
           $table->string('email', 100)->unique();
           $table->integer('discount_rate');
           $table->decimal('balance', 10, 2);
           $table->datetime('reg_datetime');
           $table->datetime('last_login_datetime')->nullable();
           $table->string('last_login_ip', 15)->nullable();
           $table->integer('last_login_geocountry')->nullable();
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
        Schema::drop('chs_resellers');
    }
}
