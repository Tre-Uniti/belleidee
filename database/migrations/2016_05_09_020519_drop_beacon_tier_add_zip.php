<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropBeaconTierAddZip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beacons', function (Blueprint $table) {
            $table->dropColumn('tier');
            $table->string('zip', 10)->nullable();
        });

        Schema::table('beacon_requests', function (Blueprint $table) {
            $table->string('zip', 10)->nullable();
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
            $table->integer('tier');
            $table->dropColumn('zip');
        });

        Schema::table('beacon_requests', function (Blueprint $table) {
            $table->dropColumn('zip');
        });
    }
}
