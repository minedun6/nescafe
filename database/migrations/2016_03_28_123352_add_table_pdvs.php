<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTablePdvs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdvs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('sector')->nullable();
            $table->string('cds')->nullable();
            $table->boolean('is_labeled')->nullable();
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
        Schema::drop('pdvs');
    }
}
