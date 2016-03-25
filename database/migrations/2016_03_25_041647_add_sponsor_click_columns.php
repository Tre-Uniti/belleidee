<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSponsorClickColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->integer('clicks')->unsigned();
            $table->integer('click_budget')->unsigned();
            $table->renameColumn('budget', 'view_budget');
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
            $table->dropColumn('clicks');
            $table->dropColumn('click_budget');
            $table->renameColumn('view_budget', 'budget');
        });
    }
}
