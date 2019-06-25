<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFichesTechniquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiches_techniques', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('nom')->nullable();
            $table->string('path')->nullable();
            $table->string('cible')->default('VDI');
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
        Schema::drop('fiches_techniques');
    }
}
