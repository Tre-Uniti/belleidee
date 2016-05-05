<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBeaconTagToIntolerance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('intolerances', function (Blueprint $table) {
            $table->string('beacon_tag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('intolerances', function (Blueprint $table) {
            $table->dropColumn('beacon_tag');
        });
    }
}
