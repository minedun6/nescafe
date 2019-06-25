<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModifyPdvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdvs', function (Blueprint $table) {
            $table->dropColumn('is_labeled');
            $table->string('category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdvs', function (Blueprint $table) {
            $table->boolean('is_labeled')->nullable();
            $table->dropColumn('category');
        });
    }
}
