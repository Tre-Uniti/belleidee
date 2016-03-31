<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeaconSponsorAdminUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beacon_requests', function (Blueprint $table) {
            $table->string('admin');
            $table->string('status');
        });
        Schema::table('sponsor_requests', function (Blueprint $table) {
            $table->string('admin');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beacon_requests', function (Blueprint $table) {
            $table->dropColumn('admin');
            $table->dropColumn('status');
        });
        Schema::table('sponsor_requests', function (Blueprint $table) {
            $table->dropColumn('admin');
            $table->dropColumn('status');
        });
    }
}
