<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extensions', function (Blueprint $table)
        {
            $table->increments('extension_id');
            $table->string('title');
            $table->integer('elevation')->unsigned();
            $table->integer('extension')->unsigned();
            $table->integer('master_version')->unsigned();
            $table->string('nymified')->nullable();
            $table->string('extIndex')->nullable();
            $table->string('ext2Index')->nullable();
            $table->string('extension_path');
            $table->string('extSource_path');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('extensions');
    }
}
