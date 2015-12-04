<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extensions', function ($table) {
            $table->renameColumn('extension_index', 'index');
            $table->renameColumn('extension_belief_beacon', 'belief_beacon');
            $table->renameColumn('extension_index2', 'index2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extensions', function ($table) {
            $table->renameColumn('index', 'extension_index');
            $table->renameColumn('belief_beacon', 'extension_belief_beacon');
            $table->renameColumn('index2', 'extension_index2');
        });
    }
}



