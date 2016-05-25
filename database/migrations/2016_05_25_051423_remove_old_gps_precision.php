<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveOldGpsPrecision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beacons', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('long');
        });
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('long');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('long');
        });
        Schema::table('extensions', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('long');
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
            $table->double('lat', 10, 7)->nullable();
            $table->double('long', 10, 7)->nullable();
        });
        Schema::table('sponsors', function (Blueprint $table) {
            $table->double('lat', 10, 7)->nullable();
            $table->double('long', 10, 7)->nullable();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->double('lat', 10, 7)->nullable();
            $table->double('long', 10, 7)->nullable();
        });
        Schema::table('extensions', function (Blueprint $table) {
            $table->double('lat', 10, 7)->nullable();
            $table->double('long', 10, 7)->nullable();
        });
    }
}
