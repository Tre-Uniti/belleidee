<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailSponsorBeaconRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beacon_requests', function (Blueprint $table) {
            $table->string('email');
        });
        Schema::table('sponsor_requests', function (Blueprint $table) {
            $table->string('email');
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
            $table->dropColumn('email');
        });
        Schema::table('sponsor_requests', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}
