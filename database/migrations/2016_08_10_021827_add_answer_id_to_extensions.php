<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnswerIdToExtensions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extensions', function (Blueprint $table) {
            $table->integer('answer_id')->unsigned()->nullable()->after('extenception');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extensions', function (Blueprint $table) {
            $table->dropColumn('answer_id');
        });
    }
}
