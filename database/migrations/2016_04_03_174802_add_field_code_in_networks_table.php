<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCodeInNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('networks', function (Blueprint $table) {
            $table->string('code')->nullable();
        });
        Schema::table('check_lists', function (Blueprint $table) {
            $table->string('code')->nullable();
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
            $table->dropColumn('code');
        });
        Schema::table('check_lists', function (Blueprint $table) {
            $table->dropColumn('code');
        });

    }
}
