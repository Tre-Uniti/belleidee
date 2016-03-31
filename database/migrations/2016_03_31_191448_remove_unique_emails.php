<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUniqueEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beacon_requests', function (Blueprint $table) {
            $table->dropUnique('beacon_requests_email_unique');
            $table->dropColumn('email');
        });
        Schema::table('sponsor_requests', function (Blueprint $table) {
            $table->dropUnique('sponsor_requests_email_unique');
            $table->dropColumn('email');
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

            $table->string('email')->unique();
        });
        Schema::table('sponsor_requests', function (Blueprint $table) {

            $table->string('email')->unique();
        });
    }
}
