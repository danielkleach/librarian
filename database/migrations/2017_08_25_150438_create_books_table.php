<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('owner_id')->unsigned()->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('isbn');
            $table->smallInteger('publication_year')->unsigned();
            $table->string('location');
            $table->string('cover_image_url')->nullable();
            $table->string('status')->default('available');
            $table->boolean('featured')->default(0);
            $table->integer('total_rentals')->default(0);
            $table->decimal('rating', 3, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
