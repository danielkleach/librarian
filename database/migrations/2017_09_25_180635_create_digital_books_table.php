<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDigitalBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->string('isbn')->nullable();
            $table->smallInteger('publication_year')->unsigned();
            $table->string('cover_image_url')->nullable();
            $table->boolean('featured')->default(0);
            $table->integer('download_count')->default(0);
            $table->decimal('rating', 3, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_books');
    }
}
