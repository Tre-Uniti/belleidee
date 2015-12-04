<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnCleanup extends Migration
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
        Schema::table('users', function ($table) {
            $table->dropColumn('motto');
            $table->dropColumn('photo_path2');
            $table->dropColumn('photo_path_temp2');
            $table->renameColumn('user_elevation', 'elevation');
            $table->renameColumn('user_extension', 'extension');
            $table->renameColumn('photo_path1', 'photo_path');
            $table->renameColumn('photo_path_temp1', 'photo_path_temp');
        });

        /*
         * Remove sponsor_ from column names, add missed for missed views
         */
        Schema::table('sponsors', function ($table) {
            $table->dropColumn('sponsor_path2');
            $table->renameColumn('sponsor_name', 'name');
            $table->renameColumn('sponsor_website', 'website');
            $table->renameColumn('sponsor_phone', 'phone');
            $table->renameColumn('sponsor_path1', 'photo_path');
            $table->integer('missed')->unsigned();

        });

        /*
        *  Remove source_path, remove draft_ from column names
        */
        Schema::table('drafts', function ($table) {
            $table->dropColumn('source_path');
            $table->renameColumn('draft_index', 'index');
            $table->renameColumn('draft_belief_beacon', 'belief_beacon');
            $table->renameColumn('draft_index2', 'index2');
        });

        /*
       *  Remove question_ from column names
       */
        Schema::table('questions', function ($table) {
            $table->renameColumn('question_elevation', 'elevation');
            $table->renameColumn('question_extension', 'extension');
        });

        /*
        *  Remove 2 unnecessary columns and rename
        */
        Schema::table('intolerant', function ($table) {
            $table->dropColumn('sponsor_path2');
            $table->dropColumn('photo_path2');
            $table->renameColumn('photo_path1', 'photo_path');
            $table->renameColumn('descentLevel', 'severity');
        });
        /*
        *  Remove question_ from column names
        */
        Schema::table('beacons', function ($table) {
            $table->renameColumn('beliefcenter', 'belief');
            $table->renameColumn('beacon_email', 'email');
            $table->renameColumn('beacon_top1', 'top1');
            $table->renameColumn('beacon_top2', 'top2');
            $table->renameColumn('beacon_top3', 'top3');
            $table->renameColumn('beacon_use', 'tag_usage');
        });

        /*
        *  Drop 3 unnecessary columns remove legacy_ from column names
        */
        Schema::table('legacy', function ($table) {
            $table->dropColumn('motto');
            $table->dropColumn('photo_path2');
            $table->dropColumn('email');
            $table->renameColumn('photo_path1', 'photo_path');
            $table->renameColumn('legacy_elevation', 'elevation');
            $table->renameColumn('legacy_extension', 'extension');
        });

        /*
        *  Sourcing will be done by users in "" (Author, identifier, location)
        */
        Schema::drop('sources');

        /*
        *  Add 5 necessary fields
        */
        Schema::table('artists', function ($table) {
            $table->string('name');
            $table->string('photo_path');
            $table->integer('elevation')->unsigned();
            $table->integer('extension')->unsigned();
            $table->string('token');
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
        * Add 3 necessary columns, rename photo paths
        */
        Schema::table('users', function ($table) {
            $table->string('motto')->nullable();
            $table->string('photo_path2')->nullable();
            $table->string('photo_path_temp2')->nullable();
            $table->renameColumn('elevation', 'user_elevation');
            $table->renameColumn('extension', 'user_extension');
            $table->renameColumn('photo_path', 'photo_path1');
            $table->renameColumn('photo_path_temp', 'photo_path_temp1');
        });

        /*
        * Add sponsor_ to column names, remove missed for missed views
        */
        Schema::table('sponsors', function ($table) {
            $table->dropColumn('missed');
            $table->string('sponsor_path2')->nullable();
            $table->renameColumn('name', 'sponsor_name');
            $table->renameColumn('website', 'sponsor_website');
            $table->renameColumn('phone', 'sponsor_phone');
            $table->renameColumn('photo_path', 'sponsor_path1');
        });

        /*
        *  Add source_path, add draft_ to column names
        */
        Schema::table('drafts', function ($table) {
            $table->string('source_path');
            $table->renameColumn('index', 'draft_index');
            $table->renameColumn('belief_beacon', 'draft_belief_beacon');
            $table->renameColumn('index2', 'draft_index2');
        });

        /*
        *  Add question_ to column names
        */
        Schema::table('questions', function ($table) {
            $table->renameColumn('elevation', 'question_elevation');
            $table->renameColumn('extension', 'question_extension');
        });

        /*
        *  Add 2 necessary columns and rename
        */
        Schema::table('intolerant', function ($table) {
            $table->string('sponsor_path2')->nullable();
            $table->string('photo_path2')->nullable();
            $table->renameColumn('photo_path', 'photo_path1');
            $table->renameColumn('severity', 'descentLevel');
        });

        /*
        *  Add beacon_ to column names
        */
        Schema::table('beacons', function ($table) {

            $table->renameColumn('belief', 'beliefcenter');
            $table->renameColumn('email', 'beacon_email');
            $table->renameColumn('top1', 'beacon_top1');
            $table->renameColumn('top2', 'beacon_top2');
            $table->renameColumn('top3', 'beacon_top3');
            $table->renameColumn('tag_usage', 'beacon_use');
        });

        /*
        *  Add 3 necessary columns, add legacy_ to columns
        */
        Schema::table('legacy', function ($table) {
            $table->string('motto');
            $table->string('photo_path2')->nullable();
            $table->string('email');
            $table->renameColumn('photo_path', 'photo_path1');
            $table->renameColumn('elevation', 'legacy_elevation');
            $table->renameColumn('extension', 'legacy_extension');
        });

        /*
        *  Add sources table
        */
        Schema::create('sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nameHandle');
            $table->string('url')->nullable();
            $table->string('isbn')->nullable();
            $table->string('loc');
            $table->integer('post_id')->unsigned()->nullable();
            $table->integer('extension_id')->unsigned()->nullable();
            $table->integer('question_id')->unsigned()->nullable();
            $table->integer('legacy_post_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        /*
        *  Remove 5 unnecessary fields
        */
        Schema::table('artists', function ($table) {
            $table->dropColumn('name');
            $table->dropColumn('photo_path');
            $table->dropColumn('elevation');
            $table->dropColumn('extension');
            $table->dropColumn('token');
        });
    }
}
