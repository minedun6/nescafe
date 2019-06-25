<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoteToVisitPhotoAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->text('note')->nullable();
        });
        Schema::table('photos', function (Blueprint $table) {
            $table->text('note')->nullable();
        });
        Schema::table('answers', function (Blueprint $table) {
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn('note');
        });
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn('note');
        });
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
}
