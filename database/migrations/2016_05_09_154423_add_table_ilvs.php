<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableIlvs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilvs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('target')->nullable();
            $table->string('name')->nullable();
            $table->integer('network_type_id')->nullable();
            $table->integer('photo_id')->nullable();
            $table->boolean('should_notify')->default(false);
            $table->softDeletes();
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
        Schema::drop('ilvs');
    }
}
