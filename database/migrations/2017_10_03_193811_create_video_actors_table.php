<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoActorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_actors', function (Blueprint $table) {
            $table->integer('video_id')->unsigned();
            $table->integer('actor_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('video_id')->references('id')->on('videos');
            $table->foreign('actor_id')->references('id')->on('actors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_actors');
    }
}
