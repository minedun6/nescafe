<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDatabaseSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('networks', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->integer('type_id')->nullable();
        });

        Schema::create('network_types', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('code')->nullable();
            $table->string('value')->nullable();
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
        Schema::table('networks', function (Blueprint $table) {
            $table->dropColumn('type_id');
            $table->string('type')->nullable();
        });

        Schema::drop('network_types');
    }
}
