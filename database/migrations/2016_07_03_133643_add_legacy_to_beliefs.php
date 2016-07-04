<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLegacyToBeliefs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beliefs', function (Blueprint $table) {
            $table->integer('legacy_posts')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beliefs', function (Blueprint $table) {
            $table->dropColumn('legacy_posts');
        });
    }
}
