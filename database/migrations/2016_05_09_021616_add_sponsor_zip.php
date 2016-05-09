<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSponsorZip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->string('zip', 10)->nullable();
        });

        Schema::table('sponsor_requests', function (Blueprint $table) {
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
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn('zip');
        });

        Schema::table('sponsor_requests', function (Blueprint $table) {
            $table->dropColumn('zip');
        });
    }
}
