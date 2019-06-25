<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTableDailyVisits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('daily_visits');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('daily_visits', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('visit_id')->nullable();
            $table->timestamps();
        });
    }
}
