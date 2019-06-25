<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('supervisor_id')->nullable();
            $table->integer('merch_id')->nullable();
            $table->text('message')->nullable();
            $table->integer('visit_id')->nullable();
            $table->string('target_type')->nullable();
            $table->integer('target_id')->nullable();
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
        Schema::drop('notes');
    }
}
