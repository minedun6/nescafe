<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('delegation_id');
        });
        Schema::drop('franchises');
        Schema::create('franchises', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('time')->nullable();
            $table->string('time_sunday')->nullable();
            $table->integer('network_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->integer('delegation_id')->nullable();
        });
    }
}
