<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToPostsExtensions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
       * Add Status for intolerance
       */
        Schema::table('posts', function ($table) {
            $table->tinyinteger('status')->unsigned()->nullable();
        });

        /*
         * Add Status for intolerance
         */
        Schema::table('extensions', function ($table) {
            $table->tinyinteger('status')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        * Remove Status for intolerance
        */
        Schema::table('posts', function ($table) {
            $table->dropColumn('status');
        });

        /*
         * Remove Status for intolerance
         */
        Schema::table('extensions', function ($table) {
            $table->dropColumn('status');
        });
    }
}
