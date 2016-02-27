<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSponsorStripe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->string('customer_id')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->dropColumn('triggers');
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
            $table->dropColumn('customer_id');
            $table->dropColumn('user_id');
            $table->integer('triggers')->unsigned();
        });
    }
}
