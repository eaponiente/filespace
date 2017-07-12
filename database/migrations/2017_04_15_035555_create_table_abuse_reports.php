<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAbuseReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chs_abuse_reports', function(Blueprint $table) {
             $table->increments('id');
             $table->string('code', 20);
             $table->string('name', 80);
             $table->string('organization', 100);
             $table->string('email', 100);
             $table->text('links');
             $table->text('reason');
             $table->string('uploaded_filename', 128);
             $table->datetime('report_datetime');
             $table->datetime('reply_datetime')->nullable();
             $table->text('message');
             $table->enum('resolved', ['1','0'])->default(0);
             $table->integer('reported_links_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chs_abuse_reports');
    }
}
