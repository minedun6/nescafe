<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableFranchises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchises', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->time('time_open')->nullable();
            $table->time('time_close')->nullable();
            $table->time('time_open_sunday')->nullable();
            $table->time('time_close_sunday')->nullable();
            $table->integer('network_id')->nullable();
            $table->boolean('is_sunday_open')->nullable();
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
        Schema::drop('franchises');
    }
}
