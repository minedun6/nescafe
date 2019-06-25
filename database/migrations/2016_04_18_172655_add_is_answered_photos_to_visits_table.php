<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsAnsweredPhotosToVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->boolean('is_answered_branding')->default(false);
            $table->boolean('is_answered_display')->default(false);
            $table->boolean('is_answered_online')->default(false);
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
            $table->dropColumn('is_answered_branding');
            $table->dropColumn('is_answered_display');
            $table->dropColumn('is_answered_online');
        });
    }
}
