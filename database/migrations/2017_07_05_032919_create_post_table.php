<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('post', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('uid');
            $table->smallInteger('tid');
            $table->string('title');
            $table->text('content');
            $table->string('music');
            $table->string('video');
            $table->string('img');
            $table->timestamps();
            $table->smallInteger('count');
            $table->smallInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('post');
    }
}
