<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBeaconTagViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beacons', function (Blueprint $table) {
            $table->integer('tag_views')->unsigned();
            $table->integer('total_tag_usage')->unsigned();
            $table->dropColumn('top1');
            $table->dropColumn('top2');
            $table->dropColumn('top3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beacons', function (Blueprint $table) {
            $table->string('top1');
            $table->string('top2');
            $table->string('top3');
            $table->dropColumn('tag_views');
            $table->dropColumn('total_tag_usage');
        });
    }
}
