<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDigitalBookAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_book_authors', function (Blueprint $table) {
            $table->integer('book_id')->unsigned();
            $table->integer('author_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('book_id')->references('id')->on('digital_books');
            $table->foreign('author_id')->references('id')->on('authors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_book_authors');
    }
}
