<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('notes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('superviseur_id')->nullable();
            $table->integer('merch_id')->nullable();
            $table->text('message')->nullable();
            $table->string('target')->nullable();
            $table->integer('target_id')->nullable();
            $table->timestamps();
        });
    }
}
