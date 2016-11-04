<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSafePostToBeacons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beacons', function (Blueprint $table) {
            $table->boolean('safePost')->nullable();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('safePost')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beacons', function (Blueprint $table) {
            $table->dropColumn('safePost');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('safePost');
        });
    }
}
