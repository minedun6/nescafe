<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatabaseAdjustement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('delegations');
        Schema::drop('governorates');
        Schema::drop('zones');
        Schema::table('cities', function (Blueprint $table) {
            $table->string('delegation')->nullable();
            $table->string('governorate')->nullable();
            $table->string('zone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->timestamps();
        });
        Schema::create('governorates', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->integer('zone_id')->nullable();
            $table->timestamps();
        });
        Schema::create('delegations', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->integer('governorate_id')->nullable();
            $table->timestamps();
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('delegation');
            $table->dropColumn('governorate');
            $table->dropColumn('zone');
        });
    }
}
