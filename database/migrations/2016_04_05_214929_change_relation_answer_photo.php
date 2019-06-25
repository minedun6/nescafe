<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRelationAnswerPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->integer('photo_id')->nullable();
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn('answer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('photo_id');
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->integer('answer_id')->nullable();
        });
    }
}
