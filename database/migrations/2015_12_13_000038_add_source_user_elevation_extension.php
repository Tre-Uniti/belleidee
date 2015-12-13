<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSourceUserElevationExtension extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extensions', function ($table) {
            $table->integer('source_user')->unsigned();
        });
        Schema::table('elevation', function ($table) {
            $table->integer('source_user')->unsigned();
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
            $table->dropColumn('source_user');
        });
        Schema::table('elevation', function ($table) {
            $table->dropColumn('source_user');
        });
    }

}
