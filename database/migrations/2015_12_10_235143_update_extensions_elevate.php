<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateExtensionsElevate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extensions', function ($table) {
            $table->integer('elevation')->unsigned();
            $table->integer('extension')->unsigned();
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
            $table->dropColumn('elevation');
            $table->dropColumn('extension');
        });
    }
}
