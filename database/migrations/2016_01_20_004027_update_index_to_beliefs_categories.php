<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIndexToBeliefsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        * Rename index columns to belief and categories
        */
        Schema::table('posts', function ($table) {
            $table->renameColumn('index', 'belief');
            $table->renameColumn('index2', 'category');
        });

        /*
        * Rename index columns to belief and categories
        */
        Schema::table('extensions', function ($table) {
            $table->renameColumn('index', 'belief');
            $table->renameColumn('index2', 'category');
        });

        /*
        * Rename index columns to belief and categories
        */
        Schema::table('drafts', function ($table) {
            $table->renameColumn('index', 'belief');
            $table->renameColumn('index2', 'category');
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
        * Rename index columns to belief and categories
        */
        Schema::table('posts', function ($table) {
            $table->renameColumn('belief', 'index');
            $table->renameColumn('category', 'index2');
        });

        /*
        * Rename index columns to belief and categories
        */
        Schema::table('extensions', function ($table) {
            $table->renameColumn('belief', 'index');
            $table->renameColumn('category', 'index2');
        });

        /*
        * Rename index columns to belief and categories
        */
        Schema::table('drafts', function ($table) {
            $table->renameColumn('belief', 'index');
            $table->renameColumn('category', 'index2');
        });
    }
}
