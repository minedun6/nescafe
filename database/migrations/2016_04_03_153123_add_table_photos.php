<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTablePhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('path')->nullable();
            $table->dateTime('photo_date')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->integer('photo_set_id')->nullable();
            $table->integer('answer_id')->nullable();
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
        Schema::drop('photos');
    }
}
