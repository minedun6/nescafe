<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToFichesTechniquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiches_techniques', function (Blueprint $table) {
            $table->string('category')->default('-');
            $table->string('subcategory')->default('-');
            $table->integer('network_type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiches_techniques', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('subcategory');
            $table->dropColumn('network_type_id');
        });
    }
}
