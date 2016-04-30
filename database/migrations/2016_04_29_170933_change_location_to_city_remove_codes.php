<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLocationToCityRemoveCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beacons', function (Blueprint $table) {
            $table->renameColumn('country_code', 'country');
            $table->renameColumn('location_code', 'city');
        });

        Schema::table('sponsors', function (Blueprint $table) {
            $table->renameColumn('location', 'city');
        });

        Schema::table('beacon_requests', function (Blueprint $table) {
            $table->renameColumn('location', 'city');
        });

        Schema::table('sponsor_requests', function (Blueprint $table) {
            $table->renameColumn('location', 'city');
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
            $table->renameColumn('country', 'country_code');
            $table->renameColumn('city', 'location_code');
        });

        Schema::table('sponsors', function (Blueprint $table) {
            $table->renameColumn('city', 'location');
        });

        Schema::table('beacon_requests', function (Blueprint $table) {
            $table->renameColumn('city', 'location');
        });

        Schema::table('sponsor_requests', function (Blueprint $table) {
            $table->renameColumn('city', 'location');
        });
    }
}
