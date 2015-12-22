<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBeaconTagCreations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
       * Remove 3 unnecessary columns, rename photo paths
       */
        Schema::table('posts', function ($table) {
            $table->renameColumn('belief_beacon', 'beacon_tag');
        });
        Schema::table('extensions', function ($table) {
            $table->renameColumn('belief_beacon', 'beacon_tag');
        });
        Schema::table('drafts', function ($table) {
            $table->renameColumn('belief_beacon', 'beacon_tag');
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
* Remove 3 unnecessary columns, rename photo paths
*/
        Schema::table('posts', function ($table) {
            $table->renameColumn('beacon_tag', 'belief_beacon');
        });
        Schema::table('extensions', function ($table) {
            $table->renameColumn('beacon_tag', 'belief_beacon');
        });
        Schema::table('drafts', function ($table) {
            $table->renameColumn('beacon_tag', 'belief_beacon');
        });
    }
}
