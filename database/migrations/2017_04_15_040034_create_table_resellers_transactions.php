<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableResellersTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_resellers_transactions', function(Blueprint $table) {
             $table->increments('id');
             $table->enum('type', ['funding','voucher']);
             $table->decimal('amount', 10, 2);
             $table->integer('voucher_id');
             $table->decimal('previous_balance', 10, 2)->nullable();
             $table->decimal('new_balance', 10, 2)->nullable();
             $table->text('funding_note');
             $table->decimal('transferred_amount', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_resellers_transactions');
    }
}
